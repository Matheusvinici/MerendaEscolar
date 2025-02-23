<?php
namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Alimento;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{
    public function create()
    {
        $alimentos = Alimento::all(); // Lista de alimentos para selecionar
        return view('orcamentos.create', compact('alimentos'));
    }

    public function store(Request $request)
{
    // Validação dos dados recebidos
    $request->validate([
        'descricao' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after_or_equal:data_inicio',
        'dias_letivos' => 'required|integer|min:1',
        'alimentos' => 'required|array',
        'alimentos.*.preco_unitario' => 'required|numeric|min:0.01',
    ]);

    // Criar um novo orçamento
    $orcamento = Orcamento::create([
        'descricao' => $request->descricao,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        'dias_letivos' => $request->dias_letivos,
    ]);

    $totalGeral = 0;

    // Associar alimentos ao orçamento
    foreach ($request->alimentos as $alimento_id => $data) {
        $alimento = Alimento::find($alimento_id);

        if ($alimento) {
            $valor_medio = $data['preco_unitario'] ?? 0;

            // Calcular o custo total do alimento
            $total_alimento = $alimento->total_kg_litro * $request->dias_letivos * $valor_medio;

            // Associar o alimento ao orçamento com os valores corretos
            $orcamento->alimentos()->attach($alimento_id, [
                'valor_medio' => $valor_medio,
                'custo_total' => $total_alimento,
            ]);

            // Acumular o custo total do orçamento
            $totalGeral += $total_alimento;
        }
    }

            // Atualizar o total do orçamento
            $orcamento->update(['total' => $totalGeral]);

            return redirect()->route('orcamentos.index')->with('success', 'Orçamento cadastrado com sucesso!');
        }


        public function index()
        {
            // Ordena os orçamentos do mais recente para o mais antigo
            $orcamentos = Orcamento::latest()->paginate(5); // ou use ->orderBy('created_at', 'desc')
            return view('orcamentos.index', compact('orcamentos'));
        }


                // Método show
                public function show($id)
                {
                    // Buscar o orçamento pelo ID
                    $orcamento = Orcamento::findOrFail($id);
                
                    // Retornar a view com os dados do orçamento
                    return view('orcamentos.show', compact('orcamento'));
                }
                

                public function edit(Orcamento $orcamento)
                {
                    // Carregar todos os alimentos disponíveis para edição
                    $alimentos = Alimento::all();

                    return view('orcamentos.edit', compact('orcamento', 'alimentos'));
                }
            public function update(Request $request, Orcamento $orcamento)
            {
                $request->validate([
                    'descricao' => 'required|string|max:255',
                    'data_inicio' => 'required|date',
                    'data_fim' => 'required|date|after_or_equal:data_inicio',
                    'dias_letivos' => 'required|integer|min:1',
                    'alimentos' => 'required|array',
                    'alimentos.*.preco_unitario' => 'required|numeric|min:0.01',
                ]);

                $orcamento->update($request->only(['descricao', 'data_inicio', 'data_fim', 'dias_letivos']));

                $orcamento->alimentos()->detach();

                $totalGeral = 0;
                foreach ($request->alimentos as $alimento_id => $data) {
                    $valor_medio = $data['preco_unitario'];
                    $alimento = Alimento::find($alimento_id);
                    $total_alimento = $alimento->total_kg_litro * $request->dias_letivos * $valor_medio;
                    $orcamento->alimentos()->attach($alimento_id, ['valor_medio' => $valor_medio, 'custo_total' => $total_alimento]);
                    $totalGeral += $total_alimento;
                }

                $orcamento->update(['total' => $totalGeral]);

                return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso!');
            }

            // Método destroy
            public function destroy($id)
            {
                // Buscar o orçamento pelo ID
                $orcamento = Orcamento::findOrFail($id);

                // Excluir o orçamento
                $orcamento->delete();

                // Redirecionar para a lista de orçamentos com uma mensagem de sucesso
                return redirect()->route('orcamentos.index')->with('success', 'Orçamento excluído com sucesso.');
            }


}
