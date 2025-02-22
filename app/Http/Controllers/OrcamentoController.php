<?php

// app/Http/Controllers/OrcamentoController.php
namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Alimento;
use App\Models\OrcamentoAlimento;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{
    public function create()
    {
        $alimentos = Alimento::all();
        return view('orcamentos.create', compact('alimentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string',
            'alimentos' => 'required|array',
            'alimentos.*.id' => 'exists:alimentos,id',
            'alimentos.*.quantidade' => 'required|numeric|min:0.01',
        ]);
    
        $orcamento = Orcamento::create([
            'descricao' => $request->descricao,
            'total_estimado' => 0, // Será atualizado depois
        ]);
    
        $totalEstimado = 0;
    
        foreach ($request->alimentos as $item) {
            $alimento = Alimento::findOrFail($item['id']);
            $valorUnitario = $alimento->valor_medio;
            $valorTotal = $item['quantidade'] * $valorUnitario;
    
            OrcamentoAlimento::create([
                'orcamento_id' => $orcamento->id,
                'alimento_id' => $alimento->id,
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $valorUnitario,
          
                'valor_total' => $valorTotal,
            ]);
    
            $totalEstimado += $valorTotal;
        }
    
        // Atualizar o total estimado do orçamento
        $orcamento->update(['total_estimado' => $totalEstimado]);
    
        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso!');
    }
    

    public function index()
    {
        // Ordena os orçamentos do mais recente para o mais antigo
        $orcamentos = Orcamento::latest()->paginate(5); // ou use ->orderBy('created_at', 'desc')
        return view('orcamentos.index', compact('orcamentos'));
    }
    
    public function show($id)
{
    // Busca o orçamento pelo ID
    $orcamento = Orcamento::with('alimentos')->findOrFail($id);

    // Retorna a view com os detalhes do orçamento
    return view('orcamentos.show', compact('orcamento'));
}
public function edit($id)
{
    // Encontre o orçamento com o ID fornecido
    $orcamento = Orcamento::findOrFail($id);

    // Retorne a view de edição com os dados do orçamento
    return view('orcamentos.edit', compact('orcamento'));
}
public function update(Request $request, $id)
{
    // Validação dos dados recebidos
    $request->validate([
        'descricao' => 'required|string|max:255',
        'total_estimado' => 'required|numeric|min:0',
    ]);

    // Encontre o orçamento pelo ID
    $orcamento = Orcamento::findOrFail($id);

    // Atualize os dados do orçamento com os valores do formulário
    $orcamento->descricao = $request->input('descricao');
    $orcamento->total_estimado = $request->input('total_estimado');

    // Salve as alterações no banco de dados
    $orcamento->save();

    // Redirecione o usuário de volta para a lista de orçamentos com uma mensagem de sucesso
    return redirect()->route('orcamentos.index')->with('success', 'Orçamento atualizado com sucesso!');
}


}
