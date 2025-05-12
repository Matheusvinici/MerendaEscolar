<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;

class EscolaController extends Controller
{
    public function index()
    {
        $escolas = Escola::withCount('alunos')->get();
        return view('escolas.index', compact('escolas'));
    }

    public function create()
    {
        return view('escolas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'codigo_inep' => 'required|string|max:20|unique:escolas'
        ]);

        Escola::create($validated);

        return redirect()->route('escolas.index')
                         ->with('success', 'Escola cadastrada com sucesso!');
    }

    public function show(Escola $escola)
    {
        $alunos = $escola->alunos()->orderBy('ano_letivo', 'desc')->get();
        return view('escolas.show', compact('escola', 'alunos'));
    }

    public function edit(Escola $escola)
    {
        return view('escolas.edit', compact('escola'));
    }

    public function update(Request $request, Escola $escola)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'codigo_inep' => 'required|string|max:20|unique:escolas,codigo_inep,'.$escola->id
        ]);

        $escola->update($validated);

        return redirect()->route('escolas.index')
                         ->with('success', 'Escola atualizada com sucesso!');
    }

    public function destroy(Escola $escola)
    {
        if ($escola->alunos()->exists()) {
            return redirect()->route('escolas.index')
                             ->with('error', 'Não é possível excluir escola com registros de alunos!');
        }

        $escola->delete();

        return redirect()->route('escolas.index')
                         ->with('success', 'Escola removida com sucesso!');
    }
}