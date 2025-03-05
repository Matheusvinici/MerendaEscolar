<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Proposta;
use App\Models\Regiao;
use App\Models\Alimento;
use App\Models\Escola;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Exibe a lista de propostas pendentes e calcula a necessidade de alimentos por região.
     */
    public function index(Request $request)
    {
        // Filtra por região, se necessário
        $regiaoId = $request->input('regiao_id');
        $regioes = Regiao::all();

        // Obtém as propostas pendentes filtradas por região
        $propostas = Proposta::where('status', 'pendente')
                             ->when($regiaoId, function ($query) use ($regiaoId) {
                                 return $query->where('regiao_id', $regiaoId);
                             })
                             ->with(['regiao', 'alimentos'])
                             ->get();

        // Calcula a necessidade de alimentos por região
        $necessidadesPorRegiao = [];
        foreach ($regioes as $regiao) {
            $bairros = $regiao->bairros()->with('escolas')->get();
            $necessidades = [];

            foreach ($bairros as $bairro) {
                foreach ($bairro->escolas as $escola) {
                    // Calcula a necessidade de alimentos para a escola
                    foreach (Alimento::all() as $alimento) {
                        $total = 0;

                        // Pré-escola
                        if ($alimento->pre_escola_qtd && $escola->pre_escola_alunos) {
                            $total += ($alimento->pre_escola_qtd * $escola->pre_escola_alunos) / 1000; // Converte gramas para kg
                        }

                        // Fundamental
                        if ($alimento->fundamental_qtd && $escola->fundamental_alunos) {
                            $total += ($alimento->fundamental_qtd * $escola->fundamental_alunos) / 1000;
                        }

                        // EJA
                        if ($alimento->eja_qtd && $escola->eja_alunos) {
                            $total += ($alimento->eja_qtd * $escola->eja_alunos) / 1000;
                        }

                        // Adiciona ao total da região
                        if (!isset($necessidades[$alimento->id])) {
                            $necessidades[$alimento->id] = [
                                'nome' => $alimento->nome,
                                'total_necessario' => 0,
                                'total_ofertado' => 0,
                                'total_aprovado' => 0, // Nova coluna para o total aprovado
                            ];
                        }

                        $necessidades[$alimento->id]['total_necessario'] += $total;
                    }
                }
            }

            // Calcula o total ofertado nas propostas para essa região
            foreach ($propostas as $proposta) {
                if ($proposta->regiao_id == $regiao->id) {
                    foreach ($proposta->alimentos as $alimento) {
                        if (!isset($necessidades[$alimento->id])) {
                            $necessidades[$alimento->id] = [
                                'nome' => $alimento->nome,
                                'total_necessario' => 0,
                                'total_ofertado' => 0,
                                'total_aprovado' => 0, // Nova coluna para o total aprovado
                            ];
                        }

                        $necessidades[$alimento->id]['total_ofertado'] += $alimento->pivot->quantidade_ofertada;
                    }
                }
            }

            // Calcula o total aprovado por região
            foreach ($necessidades as $alimentoId => $alimento) {
                $totalAprovado = Avaliacao::whereHas('proposta', function ($query) use ($regiao) {
                    $query->where('regiao_id', $regiao->id);
                })
                ->where('status', 'aprovada')
                ->whereHas('proposta.alimentos', function ($query) use ($alimentoId) {
                    $query->where('alimento_id', $alimentoId);
                })
                ->sum('quantidade_aprovada');

                $necessidades[$alimentoId]['total_aprovado'] = $totalAprovado;
            }

            $necessidadesPorRegiao[$regiao->id] = [
                'regiao' => $regiao->nome,
                'necessidades' => $necessidades,
            ];
        }

        // Calcula o total de kg oferecidos por alimento (para a tabela de resumo)
        $alimentosTotais = [];
        foreach ($propostas as $proposta) {
            foreach ($proposta->alimentos as $alimento) {
                $alimentoId = $alimento->id;
                $quantidadeOfertada = $alimento->pivot->quantidade_ofertada;

                if (!isset($alimentosTotais[$alimentoId])) {
                    $alimentosTotais[$alimentoId] = [
                        'nome' => $alimento->nome,
                        'total_kg' => 0,
                        'limite_chamada' => $alimento->total_kg_litro,
                        'total_aprovado' => 0,
                    ];
                }

                $alimentosTotais[$alimentoId]['total_kg'] += $quantidadeOfertada;

                // Calcular o total aprovado para esse alimento
                $totalAprovado = Avaliacao::whereHas('proposta.alimentos', function ($query) use ($alimentoId) {
                    $query->where('alimento_id', $alimentoId);
                })->where('status', 'aprovada')->sum('quantidade_aprovada');

                $alimentosTotais[$alimentoId]['total_aprovado'] = $totalAprovado;
            }
        }

        return view('avaliacoes.index', compact('regioes', 'propostas', 'necessidadesPorRegiao', 'alimentosTotais', 'regiaoId'));
    }

    /**
     * Exibe o formulário para criar uma nova avaliação.
     */
    public function create(Request $request)
    {
        // Captura o ID da proposta da query string
        $propostaId = $request->query('proposta');
    
        // Verifica se o ID da proposta foi fornecido
        if (!$propostaId) {
            abort(404, 'ID da proposta não fornecido.');
        }
    
        // Carrega a proposta com os alimentos
        $proposta = Proposta::with('alimentos')->findOrFail($propostaId);
    
        // Verifica se os alimentos estão sendo carregados
        $alimentos = $proposta->alimentos;
    
        
    
        return view('avaliacoes.create', compact('proposta', 'alimentos'));
    }
    /**
     * Salva uma nova avaliação no banco de dados.
     */
    public function store(Request $request, $propostaId)
    {
        // Carrega a proposta com os alimentos
        $proposta = Proposta::findOrFail($propostaId);
    
        $request->validate([
            'status' => 'required|in:aprovada,reprovada',
            'comentario' => 'nullable|string',
            'alimentos' => 'required|array',
            'alimentos.*.quantidade_aprovada' => 'nullable|numeric|min:0',
        ]);
    
        // Atualiza o status da proposta
        $proposta->update([
            'status' => $request->status,
        ]);
    
        // Inicializa o valor total da proposta
        $valorTotalProposta = 0;
    
        // Percorre os alimentos e atualiza as quantidades aprovadas e o valor total
        foreach ($request->alimentos as $alimentoId => $dados) {
            $quantidadeAprovada = $dados['quantidade_aprovada'] ?? 0;
    
            // Obtém o valor do alimento
            $alimento = Alimento::find($alimentoId);
            $valorAlimento = $alimento->orcamentos()->first()->pivot->valor_medio;
    
            // Calcula o novo valor total com base na quantidade aprovada
            $novoValorTotal = $quantidadeAprovada * $valorAlimento;
    
            // Atualiza a quantidade aprovada e o valor total na tabela de relação proposta_alimentos
            \DB::table('proposta_alimentos')
                ->where('proposta_id', $proposta->id)
                ->where('alimento_id', $alimentoId)
                ->update([
                    'quantidade_aprovada' => $quantidadeAprovada,
                    'valor_total' => $novoValorTotal,
                ]);
    
            // Soma ao valor total da proposta
            $valorTotalProposta += $novoValorTotal;
        }
    
        // Atualiza o valor total da proposta
        $proposta->update([
            'valor_total' => $valorTotalProposta,
        ]);
    
        // Salva a avaliação
        Avaliacao::create([
            'proposta_id' => $proposta->id,
            'user_id' => auth()->id(),
            'comentario' => $request->comentario,
            'status' => $request->status,
            'quantidade_aprovada' => array_sum(array_column($request->alimentos, 'quantidade_aprovada')),
        ]);
    
        return redirect()->route('avaliacoes.index')->with('success', 'Avaliação registrada com sucesso!');
    }
    /**
     * Distribui as propostas aprovadas por região.
     */
    public function distribuir(Request $request)
    {
        // Validação (opcional)
        $request->validate([
            'regiao_id' => 'nullable|exists:regioes,id',
        ]);

        // Filtra por região, se necessário
        $regiaoId = $request->input('regiao_id');

        // Obtém as propostas aprovadas
        $propostas = Proposta::where('status', 'aprovada')
                             ->when($regiaoId, function ($query) use ($regiaoId) {
                                 return $query->where('regiao_id', $regiaoId);
                             })
                             ->get();

        // Distribui as propostas (exemplo: atualizar status para "distribuída")
        foreach ($propostas as $proposta) {
            $proposta->update(['status' => 'distribuida']);
        }

        return redirect()->route('avaliacoes.index')
                         ->with('success', 'Propostas distribuídas com sucesso!');
    }
}