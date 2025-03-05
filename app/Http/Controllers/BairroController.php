<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\Regiao;
use Illuminate\Http\Request;

class BairroController extends Controller
{
    // Listar todos os bairros
    public function index()
    {
        // Ordena os bairros por ID em ordem decrescente (último registro primeiro)
        $bairros = Bairro::with('regiao')
                         ->orderBy('id', 'desc') // Ordena por ID decrescente
                         ->paginate(5); // Paginação com 5 registros por página
    
        return view('bairros.index', compact('bairros'));
    }

    // Exibir formulário de criação
    public function create()
    {
        $regioes = Regiao::all();
        return view('bairros.create', compact('regioes'));
    }

    // Salvar novo bairro
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'regiao_id' => 'required|exists:regioes,id',
        ]);

        Bairro::create($request->all());
        return redirect()->route('bairros.index')->with('success', 'Bairro criado com sucesso!');
    }

    // Exibir detalhes de um bairro
    public function show(Bairro $bairro)
    {
        return view('bairros.show', compact('bairro'));
    }

    // Exibir formulário de edição
    public function edit(Bairro $bairro)
    {
        $regioes = Regiao::all();
        return view('bairros.edit', compact('bairro', 'regioes'));
    }

    // Atualizar bairro
    public function update(Request $request, Bairro $bairro)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'regiao_id' => 'required|exists:regioes,id',
        ]);

        $bairro->update($request->all());
        return redirect()->route('bairros.index')->with('success', 'Bairro atualizado com sucesso!');
    }

    // Excluir bairro
    public function destroy(Bairro $bairro)
    {
        $bairro->delete();
        return redirect()->route('bairros.index')->with('success', 'Bairro excluído com sucesso!');
    }
}