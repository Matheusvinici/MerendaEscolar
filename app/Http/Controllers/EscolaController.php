<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;

class EscolaController extends Controller
{
    /**
     * Exibir uma lista de escolas.
     */
    public function index()
    {
        $escolas = Escola::all();
        return view('escolas.index', compact('escolas'));
    }

    /**
     * Exibir o formulário para criação de uma nova escola.
     */
    public function create()
    {
        return view('escolas.create');
    }

    /**
     * Armazenar uma nova escola.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'inep' => 'nullable|string|max:255',
        ]);

        Escola::create($request->all());

        return redirect()->route('escolas.index')->with('success', 'Escola criada com sucesso.');
    }

    /**
     * Exibir uma escola específica.
     */
    public function show(Escola $escola)
    {
        return view('escolas.show', compact('escola'));
    }

    /**
     * Exibir o formulário para editar uma escola.
     */
    public function edit(Escola $escola)
    {
        return view('escolas.edit', compact('escola'));
    }

    /**
     * Atualizar os dados de uma escola.
     */
    public function update(Request $request, Escola $escola)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'inep' => 'nullable|string|max:255',
        ]);

        $escola->update($request->all());

        return redirect()->route('escolas.index')->with('success', 'Escola atualizada com sucesso.');
    }

    /**
     * Excluir uma escola.
     */
    public function destroy(Escola $escola)
    {
        $escola->delete();
        return redirect()->route('escolas.index')->with('success', 'Escola excluída com sucesso.');
    }
}
