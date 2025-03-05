<?php

namespace App\Http\Controllers;

use App\Models\Regiao;
use Illuminate\Http\Request;

class RegiaoController extends Controller
{
    // Listar todas as regiões
    public function index()
    {
        // Ordena os orçamentos do mais recente para o mais antigo
        $regioes = Regiao::latest()->paginate(5); // ou use ->orderBy('created_at', 'desc')
        return view('regioes.index', compact('regioes'));
    }


    // Exibir formulário de criação
    public function create()
    {
        return view('regioes.create');
    }

    // Salvar nova região
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Regiao::create($request->all());
        return redirect()->route('regioes.index')->with('success', 'Região criada com sucesso!');
    }

    // Exibir detalhes de uma região
    public function show(Regiao $regiao)
    {
        return view('regioes.show', compact('regiao'));
    }

    // Exibir formulário de edição
    public function edit(Regiao $regiao)
    {
        return view('regioes.edit', compact('regiao'));
    }

    // Atualizar região
    public function update(Request $request, Regiao $regiao)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $regiao->update($request->all());
        return redirect()->route('regioes.index')->with('success', 'Região atualizada com sucesso!');
    }

    // Excluir região
    public function destroy(Regiao $regiao)
    {
        $regiao->delete();
        return redirect()->route('regioes.index')->with('success', 'Região excluída com sucesso!');
    }
}