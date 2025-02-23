<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::all();
        return view('alimentos.index', compact('alimentos'));
    }

    public function create()
    {
        return view('alimentos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required',
        'unidade_medida' => 'required',
        'pre_escola_qtd' => 'nullable|numeric',
        'pre_escola_alunos' => 'nullable|numeric',
        'fundamental_qtd' => 'nullable|numeric',
        'fundamental_alunos' => 'nullable|numeric',
        'eja_qtd' => 'nullable|numeric',
        'eja_alunos' => 'nullable|numeric',
    ]);

    // Calcular o total de kg/litro no controller
    $totalKgLitro = 0;

    if ($request->pre_escola_qtd && $request->pre_escola_alunos) {
        $totalKgLitro += ($request->pre_escola_qtd * $request->pre_escola_alunos) / 1000;
    }
    if ($request->fundamental_qtd && $request->fundamental_alunos) {
        $totalKgLitro += ($request->fundamental_qtd * $request->fundamental_alunos) / 1000;
    }
    if ($request->eja_qtd && $request->eja_alunos) {
        $totalKgLitro += ($request->eja_qtd * $request->eja_alunos) / 1000;
    }

    // Adicionar o total calculado ao array de dados do alimento
    $data = $request->all();
    $data['total_kg_litro'] = $totalKgLitro;

    // Criar o alimento com os dados do request
    Alimento::create($data);

    return redirect()->route('alimentos.index')->with('success', 'Alimento cadastrado com sucesso!');
}


    public function show($id)
    {
        $alimento = Alimento::findOrFail($id);
        return view('alimentos.show', compact('alimento'));
    }

    // Método para realizar o cálculo do total de alimento
    private function calcularTotal($pre_escola_qtd, $pre_escola_alunos, $fundamental_qtd, $fundamental_alunos, $eja_qtd, $eja_alunos)
    {
        $total = 0;
        
        if ($pre_escola_qtd && $pre_escola_alunos) {
            $total += ($pre_escola_qtd * $pre_escola_alunos) / 1000; // Para Pré-escola
        }
        
        if ($fundamental_qtd && $fundamental_alunos) {
            $total += ($fundamental_qtd * $fundamental_alunos) / 1000; // Para Fundamental
        }

        if ($eja_qtd && $eja_alunos) {
            $total += ($eja_qtd * $eja_alunos) / 1000; // Para EJA
        }

        return $total;
    }

                // Método edit
            public function edit($id)
            {
                // Buscar o alimento pelo ID
                $alimento = Alimento::findOrFail($id);

                // Retornar a view de edição com o alimento encontrado
                return view('alimentos.edit', compact('alimento'));
            }

            // Método update
            public function update(Request $request, $id)
            {
                // Validar os dados do formulário
                $validated = $request->validate([
                    'nome' => 'required|string|max:255',
                    'unidade_medida' => 'required|in:grama,ml',
                    'pre_escola_qtd' => 'required|numeric',
                    'pre_escola_alunos' => 'required|numeric',
                    'fundamental_qtd' => 'required|numeric',
                    'fundamental_alunos' => 'required|numeric',
                    'eja_qtd' => 'required|numeric',
                    'eja_alunos' => 'required|numeric',
                ]);

                // Buscar o alimento pelo ID
                $alimento = Alimento::findOrFail($id);

                // Atualizar os dados do alimento com os dados validados
                $alimento->update([
                    'nome' => $validated['nome'],
                    'unidade_medida' => $validated['unidade_medida'],
                    'pre_escola_qtd' => $validated['pre_escola_qtd'],
                    'pre_escola_alunos' => $validated['pre_escola_alunos'],
                    'fundamental_qtd' => $validated['fundamental_qtd'],
                    'fundamental_alunos' => $validated['fundamental_alunos'],
                    'eja_qtd' => $validated['eja_qtd'],
                    'eja_alunos' => $validated['eja_alunos'],
                ]);

                // Redirecionar com sucesso
                return redirect()->route('alimentos.index')->with('success', 'Alimento atualizado com sucesso!');
            }
            // Método destroy
            public function destroy($id)
            {
                // Buscar o alimento pelo ID
                $alimento = Alimento::findOrFail($id);

                // Excluir o alimento
                $alimento->delete();

                // Redirecionar para a lista de alimentos com uma mensagem de sucesso
                return redirect()->route('alimentos.index')->with('success', 'Alimento excluído com sucesso.');
            }

}
