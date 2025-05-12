<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::orderBy('nome')->get();
        return view('alimentos.index', compact('alimentos'));
    }
        public function toggleStatus(Alimento $alimento)
    {
        $alimento->update(['ativo' => !$alimento->ativo]);
        
        return back()->with('success', 'Status do alimento atualizado com sucesso!');
    }
    public function create()
    {
        return view('alimentos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:alimentos',
            'unidade_medida' => 'required|string|max:20',
            'creche_parcial_per_capita' => 'required|numeric|min:0',
            'pre_integral_per_capita' => 'required|numeric|min:0',
            'fundamental_parcial_per_capita' => 'required|numeric|min:0',
            'fundamental_integral_per_capita' => 'required|numeric|min:0',
            'incidencia_creche_parcial' => 'required|numeric|min:0',
            'incidencia_pre_integral' => 'required|numeric|min:0',
            'incidencia_fundamental_parcial' => 'required|numeric|min:0',
            'incidencia_fundamental_integral' => 'required|numeric|min:0',
        ]);
    
        $validated['ativo'] = true; // Define 'ativo' como true por padrão
    
        Alimento::create($validated);
    
        return redirect()->route('alimentos.index')
            ->with('success', 'Alimento cadastrado com sucesso!');
    }
    public function show(Alimento $alimento)
    {
        return view('alimentos.show', compact('alimento'));
    }

    public function edit(Alimento $alimento)
    {
        return view('alimentos.edit', compact('alimento'));
    }

    public function update(Request $request, Alimento $alimento)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:alimentos,nome,'.$alimento->id,
            'unidade_medida' => 'required|string|max:20',
            'creche_parcial_per_capita' => 'required|numeric|min:0',
            'pre_integral_per_capita' => 'required|numeric|min:0',
            'fundamental_parcial_per_capita' => 'required|numeric|min:0',
            'fundamental_integral_per_capita' => 'required|numeric|min:0',
            'incidencia_creche_parcial' => 'required|numeric|min:0',
            'incidencia_pre_integral' => 'required|numeric|min:0',
            'incidencia_fundamental_parcial' => 'required|numeric|min:0',
            'incidencia_fundamental_integral' => 'required|numeric|min:0',
            'ativo' => 'sometimes|boolean',
            'disponivel_quinzena' => 'sometimes|boolean'
        ]);

        $alimento->update($validated);

        return redirect()->route('alimentos.index')
                         ->with('success', 'Alimento atualizado com sucesso!');
    }

    public function destroy(Alimento $alimento)
    {
        $alimento->delete();
        return redirect()->route('alimentos.index')
                         ->with('success', 'Alimento removido com sucesso!');
    }

    public function editDisponibilidade()
    {
        $alimentos = Alimento::where('ativo', true)
                            ->orderBy('nome')
                            ->get();
        
        return view('alimentos.quinzena', compact('alimentos'));
    }

    public function updateDisponibilidade(Request $request)
    {
        $alimentos = Alimento::where('ativo', true)->get();
        
        foreach ($alimentos as $alimento) {
            $alimento->update([
                'disponivel_quinzena' => in_array($alimento->id, $request->alimentos ?? [])
            ]);
        }

        return redirect()->route('alimentos.index')
                         ->with('success', 'Disponibilidade quinzenal atualizada!');
    }
}