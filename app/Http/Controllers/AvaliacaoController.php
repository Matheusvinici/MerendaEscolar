<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Proposta;
use App\Models\Regiao;
use App\Models\Alimento;
use App\Models\Escola;
use Illuminate\Http\Request;
use PDF; // Para geração de PDFs

class AvaliacaoController extends Controller
{
    /**
     * Exibe a lista de propostas pendentes, aprovadas e reprovadas.
     */
    public function index(Request $request)
    {
        // Filtra por região, se necessário
        $regiaoId = $request->input('regiao_id');
        $regioes = Regiao::all();

        // Obtém as propostas paginadas (2 por página) e filtradas por status e região
        $propostasPendentes = Proposta::where('status', 'pendente')
            ->when($regiaoId, function ($query) use ($regiaoId) {
                return $query->where('regiao_id', $regiaoId);
            })
            ->with(['regiao', 'alimentos'])
            ->paginate(2, ['*'], 'pendentes_page');

        $propostasAprovadas = Proposta::where('status', 'aprovada')
            ->when($regiaoId, function ($query) use ($regiaoId) {
                return $query->where('regiao_id', $regiaoId);
            })
            ->with(['regiao', 'alimentos'])
            ->paginate(2, ['*'], 'aprovadas_page');

        $propostasReprovadas = Proposta::where('status', 'reprovada')
            ->when($regiaoId, function ($query) use ($regiaoId) {
                return $query->where('regiao_id', $regiaoId);
            })
            ->with(['regiao', 'alimentos'])
            ->paginate(2, ['*'], 'reprovadas_page');

        // Calcula a necessidade de alimentos por região
        $necessidadesPorRegiao = $this->calcularNecessidadesPorRegiao($regioes, $propostasPendentes);

        // Calcula o total de kg oferecidos por alimento (para a tabela de resumo)
        $alimentosTotais = $this->calcularAlimentosTotais($propostasPendentes);

        // Calcula a porcentagem de aprovação por região
        $porcentagemAprovadaPorRegiao = $this->calcularPorcentagemAprovadaPorRegiao($regioes);

        return view('avaliacoes.index', compact(
            'regioes',
            'propostasPendentes',
            'propostasAprovadas',
            'propostasReprovadas',
            'necessidadesPorRegiao',
            'alimentosTotais',
            'porcentagemAprovadaPorRegiao',
            'regiaoId'
        ));
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
        }
    
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

    /**
     * Exporta as propostas para PDF.
     */
    public function exportPdf(Request $request)
    {
        $status = $request->query('status');
        $propostas = Proposta::where('status', $status)->get();

        $pdf = PDF::loadView('avaliacoes.export.pdf', compact('propostas', 'status'));
        return $pdf->download("propostas_$status.pdf");
    }

    /**
     * Reavalia uma proposta.
     */
    public function reavaliar(Request $request, $propostaId)
    {
        $proposta = Proposta::findOrFail($propostaId);

        // Lógica para reavaliar a proposta
        // Aqui você pode adicionar a lógica para verificar a quantidade de alimentos na região
        // e atualizar o status da proposta conforme necessário.

        return redirect()->route('avaliacoes.index')->with('success', 'Proposta reavaliada com sucesso!');
    }

    /**
     * Calcula a necessidade de alimentos por região.
     */
    private function calcularNecessidadesPorRegiao($regioes, $propostas)
    {
        $necessidadesPorRegiao = [];

        foreach ($regioes as $regiao) {
            $bairros = $regiao->bairros()->with('escolas')->get();
            $necessidades = [];

            foreach ($bairros as $bairro) {
                foreach ($bairro->escolas as $escola) {
                    foreach (Alimento::all() as $alimento) {
                        $total = 0;

                        if ($alimento->pre_escola_qtd && $escola->pre_escola_alunos) {
                            $total += ($alimento->pre_escola_qtd * $escola->pre_escola_alunos) / 1000;
                        }

                        if ($alimento->fundamental_qtd && $escola->fundamental_alunos) {
                            $total += ($alimento->fundamental_qtd * $escola->fundamental_alunos) / 1000;
                        }

                        if ($alimento->eja_qtd && $escola->eja_alunos) {
                            $total += ($alimento->eja_qtd * $escola->eja_alunos) / 1000;
                        }

                        if (!isset($necessidades[$alimento->id])) {
                            $necessidades[$alimento->id] = [
                                'nome' => $alimento->nome,
                                'total_necessario' => 0,
                                'total_ofertado' => 0,
                                'total_aprovado' => 0,
                            ];
                        }

                        $necessidades[$alimento->id]['total_necessario'] += $total;
                    }
                }
            }

            foreach ($propostas as $proposta) {
                if ($proposta->regiao_id == $regiao->id) {
                    foreach ($proposta->alimentos as $alimento) {
                        if (!isset($necessidades[$alimento->id])) {
                            $necessidades[$alimento->id] = [
                                'nome' => $alimento->nome,
                                'total_necessario' => 0,
                                'total_ofertado' => 0,
                                'total_aprovado' => 0,
                            ];
                        }

                        $necessidades[$alimento->id]['total_ofertado'] += $alimento->pivot->quantidade_ofertada;
                    }
                }
            }

            $necessidadesPorRegiao[$regiao->id] = [
                'regiao' => $regiao->nome,
                'necessidades' => $necessidades,
            ];
        }

        return $necessidadesPorRegiao;
    }

    /**
     * Calcula o total de kg oferecidos por alimento.
     */
    private function calcularAlimentosTotais($propostas)
    {
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

                $totalAprovado = Avaliacao::whereHas('proposta.alimentos', function ($query) use ($alimentoId) {
                    $query->where('alimento_id', $alimentoId);
                })->where('status', 'aprovada')->sum('quantidade_aprovada');

                $alimentosTotais[$alimentoId]['total_aprovado'] = $totalAprovado;
            }
        }

        return $alimentosTotais;
    }

    /**
     * Calcula a porcentagem de aprovação por região.
     */
    private function calcularPorcentagemAprovadaPorRegiao($regioes)
    {
        $porcentagemAprovadaPorRegiao = [];

        foreach ($regioes as $regiao) {
            $totalPropostas = Proposta::where('regiao_id', $regiao->id)->count();
            $totalAprovadas = Proposta::where('regiao_id', $regiao->id)->where('status', 'aprovada')->count();

            $porcentagemAprovadaPorRegiao[$regiao->id] = $totalPropostas > 0 ? ($totalAprovadas / $totalPropostas) * 100 : 0;
        }

        return $porcentagemAprovadaPorRegiao;
    }
}