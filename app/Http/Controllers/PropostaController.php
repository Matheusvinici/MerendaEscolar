<?php

namespace App\Http\Controllers;

use App\Models\Proposta;
use App\Models\Alimento;
use App\Models\Regiao;

use App\Models\ChamadaPublica;
use Illuminate\Http\Request;

class PropostaController extends Controller
{
    // Exibir todas as propostas
    public function index()
    {
        // Paginação e ordenação por data de criação (último cadastro primeiro)
        $propostas = Proposta::with(['chamadaPublica', 'alimentos', 'regiao', 'avaliacoes'])
                             ->orderBy('created_at', 'desc') // Ordena pelo mais recente
                             ->paginate(5); // 5 propostas por página


    
        return view('propostas.index', compact('propostas'));
    }
    

    // Exibir o formulário para criar uma nova proposta
    public function create()
    {
        // Carregar as chamadas públicas
        $chamadasPublicas = ChamadaPublica::all();
        $regioes = Regiao::with('bairros')->get(); // Carregar regiões com seus bairros   
        $alimentos = Alimento::with('propostas')->get(); // Supondo que a relação é com 'propostas' ou outra tabela
        
        return view('propostas.create', compact('chamadasPublicas', 'alimentos', 'regioes'));
    }

    public function show($id)
{
    // Busca a proposta pelo ID com os relacionamentos carregados
    $proposta = Proposta::with(['chamadaPublica', 'alimentos'])->findOrFail($id);

    return view('propostas.show', compact('proposta'));
}
    
    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'chamada_publica_id' => 'required|exists:chamadas_publicas,id',
            'regiao_id' => 'required|exists:regioes,id', // Validação da região
            'alimentos' => 'required|array',
            'alimentos.*.quantidade' => 'required|numeric|min:0',
        ]);
      

        // Criando a proposta
        $proposta = new Proposta();
        $proposta->chamada_publica_id = $request->chamada_publica_id;
        $proposta->regiao_id = $request->regiao_id; // Salvar a região

        $proposta->valor_total = 0; // Inicializando o valor total
        $proposta->save();
    
        // Inicializando o valor total geral
        $valor_total_geral = 0;
    
        // Associando alimentos e quantidades
        foreach ($request->alimentos as $alimento_id => $dados) {
            // Verifica se o alimento foi selecionado
            if (isset($dados['selecionado']) && $dados['selecionado'] == 1) {
                $alimento = Alimento::find($alimento_id);
    
                // Verificando se o alimento existe
                if (!$alimento) {
                    return back()->withErrors(['alimento' => 'Alimento não encontrado']);
                }
    
                // Verificando se a quantidade não ultrapassa a disponível
                if ($dados['quantidade'] > $alimento->total_kg_litro) {
                    return back()->with('error', 'A quantidade ofertada para ' . $alimento->nome . ' excede a quantidade disponível.');
                }
    
                // Obtendo o valor médio do alimento da tabela `orcamento_alimentos`
                $orcamentoAlimento = $alimento->orcamentos()->first();
                if (!$orcamentoAlimento) {
                    return back()->withErrors(['alimento' => 'Valor médio do alimento não encontrado']);
                }
    
                // Calculando o valor total do alimento
                $valor_total = $dados['quantidade'] * $orcamentoAlimento->pivot->valor_medio;
    
                // Atualizando o valor total da proposta
                $valor_total_geral += $valor_total;
    
                // Associando o alimento à proposta com a quantidade ofertada e o valor total
                $proposta->alimentos()->attach($alimento_id, [
                    'quantidade_ofertada' => $dados['quantidade'],
                    'valor_total' => $valor_total,
                ]);
             
            }
                    // Debug: Exibir os dados salvos
        
        }
       

        // Atualizando o valor total da proposta
        $proposta->valor_total = $valor_total_geral;
        $proposta->save();

    
        return redirect()->route('propostas.index')->with('success', 'Proposta cadastrada com sucesso!');
    }
    public function edit($id)
    {
        // Carrega a proposta existente com suas relações
        $proposta = Proposta::with('chamadaPublica', 'regiao', 'alimentos')->findOrFail($id);
        
        // Carrega todas as chamadas públicas, regiões e alimentos disponíveis
        $chamadasPublicas = ChamadaPublica::all();
        $regioes = Regiao::all();
        $alimentos = Alimento::all();
    
        // Retorna a view com os dados para edição
        return view('propostas.edit', compact('proposta', 'chamadasPublicas', 'regioes', 'alimentos'));
    }
    
    public function update(Request $request, $id)
    {
        // Validação dos dados de entrada
        $request->validate([
            'chamada_publica_id' => 'required|exists:chamadas_publicas,id',
            'regiao_id' => 'required|exists:regioes,id',
            'alimentos' => 'required|array',
            'alimentos.*.quantidade' => 'required|numeric|min:0',
        ]);
    
        // Recupera a proposta a ser atualizada
        $proposta = Proposta::findOrFail($id);
        $proposta->chamada_publica_id = $request->chamada_publica_id;
        $proposta->regiao_id = $request->regiao_id;
    
        // Inicializa o valor total
        $valor_total_geral = 0;
    
        // Limpa os alimentos existentes associados à proposta
        $proposta->alimentos()->detach();
    
        // Associa os novos alimentos e quantidades
        foreach ($request->alimentos as $alimento_id => $dados) {
            if (isset($dados['selecionado']) && $dados['selecionado'] == 1) {
                $alimento = Alimento::find($alimento_id);
    
                if (!$alimento) {
                    return back()->withErrors(['alimento' => 'Alimento não encontrado']);
                }
    
                if ($dados['quantidade'] > $alimento->total_kg_litro) {
                    return back()->with('error', 'A quantidade ofertada para ' . $alimento->nome . ' excede a quantidade disponível.');
                }
    
                // Obtém o valor médio do alimento
                $orcamentoAlimento = $alimento->orcamentos()->first();
                $valor_total = $dados['quantidade'] * $orcamentoAlimento->pivot->valor_medio;
                $valor_total_geral += $valor_total;
    
                $proposta->alimentos()->attach($alimento_id, [
                    'quantidade_ofertada' => $dados['quantidade'],
                    'valor_total' => $valor_total,
                ]);
            }
        }
    
        // Atualiza o valor total da proposta
        $proposta->valor_total = $valor_total_geral;
        $proposta->save();
    
        return redirect()->route('propostas.index')->with('success', 'Proposta atualizada com sucesso!');
    }
    

    // Excluir uma proposta
    public function destroy($id)
    {
        $proposta = Proposta::findOrFail($id);
        $proposta->delete();
        return redirect()->route('propostas.index')->with('success', 'Proposta excluída com sucesso!');
    }
}