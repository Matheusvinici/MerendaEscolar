<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Escola;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('escola')->latest()->get();
        return view('alunos.index', compact('alunos'));
    }

    public function create()
    {
        $escolas = Escola::all();
        return view('alunos.create', compact('escolas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'escola_id' => 'required|exists:escolas,id',
            'creche_parcial' => 'required|integer|min:0',
            'creche_integral' => 'required|integer|min:0',
            'pre_parcial' => 'required|integer|min:0',
            'pre_integral' => 'required|integer|min:0',
            'fundamental_parcial' => 'required|integer|min:0',
            'fundamental_integral' => 'required|integer|min:0',
            'eja' => 'required|integer|min:0',
            'ano_letivo' => 'required|string|size:9|regex:/^\d{4}\/\d{4}$/'
        ]);

        if (Aluno::where('escola_id', $validated['escola_id'])
                ->where('ano_letivo', $validated['ano_letivo'])
                ->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Já existe registro para esta escola no ano letivo informado!');
        }

        Aluno::create($validated);

        return redirect()->route('alunos.index')
                        ->with('success', 'Dados de alunos cadastrados com sucesso!');
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    public function edit(Aluno $aluno)
    {
        $escolas = Escola::all();
        return view('alunos.edit', compact('aluno', 'escolas'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'escola_id' => 'required|exists:escolas,id',
        'ano_letivo' => 'required|string|max:9',
        'creche_parcial' => 'required|integer|min:0',
        'creche_integral' => 'required|integer|min:0',
        'pre_parcial' => 'required|integer|min:0',
        'pre_integral' => 'required|integer|min:0',
        'fundamental_parcial' => 'required|integer|min:0',
        'fundamental_integral' => 'required|integer|min:0',
        'eja' => 'required|integer|min:0',
    ]);

    $aluno = Aluno::findOrFail($id);
    $aluno->update($request->all());

    return redirect()->route('alunos.index')
        ->with('success', 'Registro atualizado com sucesso!');
}
    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('alunos.index')
                         ->with('success', 'Registro de alunos removido com sucesso!');
    }

    public function calcularNecessidades(Aluno $aluno)
    {
        $alimentos = \App\Models\Alimento::where('ativo', true)->get()->map(function($alimento) use ($aluno) {
            $alimento->creche_parcial_total = $alimento->creche_parcial_per_capita * $aluno->creche_parcial;
            $alimento->pre_integral_total = $alimento->pre_integral_per_capita * $aluno->pre_integral;
            $alimento->fundamental_parcial_total = $alimento->fundamental_parcial_per_capita * $aluno->fundamental_parcial;
            $alimento->fundamental_integral_total = $alimento->fundamental_integral_per_capita * $aluno->fundamental_integral;
            $alimento->total_geral = $alimento->creche_parcial_total + 
                                    $alimento->pre_integral_total + 
                                    $alimento->fundamental_parcial_total + 
                                    $alimento->fundamental_integral_total;
            return $alimento;
        });

        return view('alunos.necessidades', [
            'aluno' => $aluno,
            'alimentos' => $alimentos
        ]);
    }
}