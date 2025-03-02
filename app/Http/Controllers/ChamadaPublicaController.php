<?php

namespace App\Http\Controllers;

use App\Models\ChamadaPublica;
use App\Models\Orcamento;
use Illuminate\Http\Request;

class ChamadaPublicaController extends Controller
{
    // Método para exibir a lista de chamadas públicas
    public function index()
    {
        $chamadasPublicas = ChamadaPublica::latest()->paginate(5); // ou use ->orderBy('created_at', 'desc')
        return view('chamadas_publicas.index', compact('chamadasPublicas'));

    }

    // Método para exibir o formulário de criação de chamada pública
    public function create()
    {
        $orcamentos = Orcamento::all(); // Recuperando todos os orçamentos

        return view('chamadas_publicas.create', compact('orcamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'data_abertura' => 'required|date',
            'data_fechamento' => 'required|date',
            'status' => 'required|string',
            'orcamento_id' => 'required|exists:orcamentos,id',
        ]);

        // Criação da chamada pública
        $chamadaPublica = ChamadaPublica::create($request->only(['titulo', 'descricao', 'data_abertura', 'data_fechamento', 'status']));

        // Associa o orçamento selecionado à chamada pública
        $chamadaPublica->orcamentos()->attach($request->orcamento_id);

        return redirect()->route('chamadas_publicas.index');
    }
    

    // Método para editar uma chamada pública
    public function edit($id)
    {
        $chamadaPublica = ChamadaPublica::findOrFail($id);
        $orcamentos = Orcamento::all();
        return view('chamadas_publicas.edit', compact('chamadaPublica', 'orcamentos'));
    }

    // Método para atualizar uma chamada pública
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_abertura' => 'required|date',
            'data_fechamento' => 'required|date|after_or_equal:data_abertura',
            'status' => 'required|in:aberta,encerrada,finalizada',
            'orcamento_id' => 'required|exists:orcamentos,id',
        ]);

        $chamadaPublica = ChamadaPublica::findOrFail($id);
        $chamadaPublica->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'data_abertura' => $request->data_abertura,
            'data_fechamento' => $request->data_fechamento,
            'status' => $request->status,
        ]);

        $chamadaPublica->orcamentos()->sync([$request->orcamento_id]);

        return redirect()->route('chamadas_publicas.index')->with('success', 'Chamada Pública atualizada com sucesso!');
    }

    // Método para exibir detalhes de uma chamada pública
    public function show($id)
    {
        $chamadaPublica = ChamadaPublica::with('orcamentos')->findOrFail($id);
        return view('chamadas_publicas.show', compact('chamadaPublica'));
    }

    // Método para excluir uma chamada pública
    public function destroy($id)
    {
        $chamadaPublica = ChamadaPublica::findOrFail($id);
        $chamadaPublica->orcamentos()->detach(); // Remover a relação com o orçamento
        $chamadaPublica->delete(); // Excluir a chamada pública

        return redirect()->route('chamadas_publicas.index')->with('success', 'Chamada Pública excluída com sucesso!');
    }
}
