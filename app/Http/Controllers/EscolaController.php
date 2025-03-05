<?php
namespace App\Http\Controllers;

use App\Models\Escola;
use App\Models\Bairro;
use Illuminate\Http\Request;

class EscolaController extends Controller
{
    // Listar todas as escolas
    public function index()
    {
        // Ordena as escolas por ID em ordem decrescente (último registro primeiro)
        $escolas = Escola::with('bairro') // Carrega o relacionamento com bairro
                         ->orderBy('id', 'desc') // Ordena por ID decrescente
                         ->paginate(5); // Paginação com 5 registros por página
    
        return view('escolas.index', compact('escolas'));
    }

    // Exibir formulário de criação
    public function create()
    {
        $bairros = Bairro::all();
        return view('escolas.create', compact('bairros'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required',
        'inep' => 'nullable',
        'bairro_id' => 'required|exists:bairros,id',
        'pre_escola_alunos' => 'nullable|integer',
        'fundamental_alunos' => 'nullable|integer',
        'eja_alunos' => 'nullable|integer',
    ]);

    Escola::create($request->all());

    return redirect()->route('escolas.index')->with('success', 'Escola cadastrada com sucesso!');
}
    // Exibir detalhes de uma escola
    public function show(Escola $escola)
    {
        return view('escolas.show', compact('escola'));
    }

    public function edit($id)
    {
        $escola = Escola::findOrFail($id);
        return view('escolas.edit', compact('escola'));
    }

    // Atualizar escola
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'inep' => 'nullable',
            'bairro_id' => 'required|exists:bairros,id',
            'pre_escola_alunos' => 'nullable|integer',
            'fundamental_alunos' => 'nullable|integer',
            'eja_alunos' => 'nullable|integer',
        ]);
    
        $escola = Escola::findOrFail($id);
        $escola->update($request->all());
    
        return redirect()->route('escolas.index')->with('success', 'Escola atualizada com sucesso!');
    }
    // Excluir escola
    public function destroy(Escola $escola)
    {
        $escola->delete();
        return redirect()->route('escolas.index')->with('success', 'Escola excluída com sucesso!');
    }
}