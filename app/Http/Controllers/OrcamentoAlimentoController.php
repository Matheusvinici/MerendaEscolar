<?php
namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Alimento;
use Illuminate\Http\Request;

class OrcamentoAlimentoController extends Controller
{
    /**
     * Exibe o formulário para adicionar alimentos a um orçamento.
     */
    public function create(Orcamento $orcamento)
    {
        $alimentos = Alimento::all();
        return view('orcamentos.alimentos.create', compact('orcamento', 'alimentos'));
    }

    /**
     * Salva os alimentos associados a um orçamento.
     */
    public function store(Request $request, Orcamento $orcamento)
    {
        // Validação dos campos
        $request->validate([
            'alimentos' => 'required|array',
            'alimentos.*' => 'exists:alimentos,id',
            'quantidades' => 'required|array',
            'quantidades.*' => 'numeric|min:0'
        ]);

        // Associando alimentos ao orçamento
        foreach ($request->alimentos as $index => $alimento_id) {
            $orcamento->alimentos()->attach($alimento_id, [
                'quantidade' => $request->quantidades[$index]
            ]);
        }

        return redirect()->route('orcamentos.show', $orcamento)->with('success', 'Alimentos adicionados ao orçamento!');
    }

    /**
     * Exibe o formulário para editar a quantidade de um alimento em um orçamento.
     */
    public function edit(Orcamento $orcamento, Alimento $alimento)
    {
        $quantidade = $orcamento->alimentos()->where('alimento_id', $alimento->id)->first()->pivot->quantidade;

        return view('orcamentos.alimentos.edit', compact('orcamento', 'alimento', 'quantidade'));
    }

    /**
     * Atualiza a quantidade de um alimento em um orçamento.
     */
    public function update(Request $request, Orcamento $orcamento, Alimento $alimento)
    {
        // Validação
        $request->validate([
            'quantidade' => 'required|numeric|min:0'
        ]);

        // Atualiza a quantidade no relacionamento pivot
        $orcamento->alimentos()->updateExistingPivot($alimento->id, [
            'quantidade' => $request->quantidade
        ]);

        return redirect()->route('orcamentos.show', $orcamento)->with('success', 'Quantidade atualizada!');
    }

    /**
     * Remove um alimento de um orçamento.
     */
    public function destroy(Orcamento $orcamento, Alimento $alimento)
    {
        $orcamento->alimentos()->detach($alimento->id);

        return redirect()->route('orcamentos.show', $orcamento)->with('success', 'Alimento removido do orçamento!');
    }
}
