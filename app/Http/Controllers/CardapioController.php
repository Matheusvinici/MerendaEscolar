<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Alimento;
use App\Models\Escola;
use App\Models\Chamada;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    // Exibe a lista de cardápios
    public function index()
    {
        $cardapios = Cardapio::all();
        return view('cardapios.index', compact('cardapios'));
    }

    // Exibe o formulário de criação de cardápio
    public function create()
    {
        $alimentos = Alimento::all(); // Lista de alimentos disponíveis
        $escolas = Escola::all(); // Lista de escolas
        return view('cardapios.create', compact('alimentos', 'escolas'));
    }

    // Armazena um novo cardápio no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade_porcao_gr' => 'nullable|numeric',
            'quantidade_kg' => 'nullable|numeric',
            'dias_servido' => 'nullable|numeric',
            'alimento_id' => 'nullable|exists:alimentos,id',
            'escola_id' => 'nullable|exists:escolas,id',
        ]);

        Cardapio::create($request->all());

        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio criado com sucesso!');
    }

    // Exibe o formulário de edição de cardápio
    public function edit($id)
    {
        $cardapio = Cardapio::find($id);
        $alimentos = Alimento::all();
        $escolas = Escola::all();
        $chamadas = Chamada::all();
        return view('cardapios.edit', compact('cardapio', 'alimentos', 'escolas', 'chamadas'));
    }

    // Atualiza um cardápio existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade_porcao_gr' => 'nullable|numeric',
            'quantidade_kg' => 'nullable|numeric',
            'dias_servido' => 'nullable|numeric',
            'chamada_id' => 'nullable|exists:chamadas,id',
            'alimento_id' => 'nullable|exists:alimentos,id',
            'escola_id' => 'nullable|exists:escolas,id',
        ]);

        $cardapio = Cardapio::find($id);
        $cardapio->update($request->all());

        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio atualizado com sucesso!');
    }

    // Exclui um cardápio
    public function destroy($id)
    {
        $cardapio = Cardapio::find($id);
        $cardapio->delete();

        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio excluído com sucesso!');
    }
}