<?php
namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller {


    public function index(Request $request)
    {
        $search = $request->input('search');
        $alimentos = Alimento::when($search, function ($query, $search) {
            return $query->where('nome', 'like', "%{$search}%");
        })->paginate(5); // ou o número de alimentos que deseja por página
    
        return view('alimentos.index', compact('alimentos'));
    }
    

    public function create() {
        return view('alimentos.create');
    }

            public function show($id)
        {
            $alimento = Alimento::findOrFail($id);
            return view('alimentos.show', compact('alimento'));
        }


    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade_medida' => 'required|string|max:50',
            'especificacao' => 'required',
            'periodicidade' => 'required|string|max:50',
            'valor_medio' => 'required|numeric|min:0'
        ]);

        Alimento::create($request->all());
        return redirect()->route('alimentos.index')->with('success', 'Alimento cadastrado com sucesso!');
    }

    public function edit(Alimento $alimento) {
        return view('alimentos.edit', compact('alimento'));
    }

    public function update(Request $request, Alimento $alimento) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade_medida' => 'required|string|max:50',
            'especificacao' => 'required',
            'periodicidade' => 'required|string|max:50',

            'valor_medio' => 'required|numeric|min:0'
        ]);

        $alimento->update($request->all());
        return redirect()->route('alimentos.index')->with('success', 'Alimento atualizado com sucesso!');
    }

    public function destroy(Alimento $alimento) {
        $alimento->delete();
        return redirect()->route('alimentos.index')->with('success', 'Alimento removido com sucesso!');
    }
}
