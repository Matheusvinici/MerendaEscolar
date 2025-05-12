<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Alimento;
use App\Models\Escola;
use App\Models\Segmento;
use PDF;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function index()
    {
        $cardapios = Cardapio::with(['alimentos', 'escola', 'segmento'])
                            ->orderBy('escola_id')
                            ->orderBy('segmento_id')
                            ->orderBy('data_inicio', 'desc')
                            ->get();
        
        $segmentos = Segmento::ativo()->get();
        $escolas = Escola::all();
        
        return view('cardapios.index', compact('cardapios', 'segmentos', 'escolas'));
    }

    public function create()
    {
        $alimentos = Alimento::where('ativo', true)->orderBy('nome')->get();
        $escolas = Escola::orderBy('nome')->get();
        $segmentos = Segmento::ativo()->get();
        
        return view('cardapios.create', compact('alimentos', 'escolas', 'segmentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'escola_id' => 'required|exists:escolas,id',
            'segmento_id' => 'required|exists:segmentos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'alimentos' => 'required|array',
            'alimentos.*' => 'exists:alimentos,id',
            'ativo' => 'sometimes|boolean',
            'padrao' => 'sometimes|boolean'
        ]);

        // Se for marcado como padrão, desmarca outros do mesmo segmento
        if ($request->padrao) {
            Cardapio::where('segmento_id', $request->segmento_id)
                  ->update(['padrao' => false]);
        }

        $cardapio = Cardapio::create([
            'nome' => $request->nome,
            'escola_id' => $request->escola_id,
            'segmento_id' => $request->segmento_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'observacoes' => $request->observacoes,
            'ativo' => $request->ativo ?? false,
            'padrao' => $request->padrao ?? false
        ]);

        // Sincronizar alimentos com dias e refeições
        $alimentosSync = [];
        foreach ($request->alimentos as $alimentoId) {
            $alimentosSync[$alimentoId] = [
                'dia_semana' => $request->input("dia_semana_$alimentoId"),
                'refeicao' => $request->input("refeicao_$alimentoId")
            ];
        }

        $cardapio->alimentos()->sync($alimentosSync);

        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio criado com sucesso!');
    }

    public function show(Cardapio $cardapio)
    {
        return view('cardapios.show', compact('cardapio'));
    }

    public function edit(Cardapio $cardapio)
    {
        $alimentos = Alimento::where('ativo', true)->orderBy('nome')->get();
        $escolas = Escola::orderBy('nome')->get();
        $segmentos = Segmento::ativo()->get();
        
        return view('cardapios.edit', compact('cardapio', 'alimentos', 'escolas', 'segmentos'));
    }

    public function update(Request $request, Cardapio $cardapio)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'escola_id' => 'required|exists:escolas,id',
            'segmento_id' => 'required|exists:segmentos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'alimentos' => 'required|array',
            'alimentos.*' => 'exists:alimentos,id',
            'ativo' => 'sometimes|boolean',
            'padrao' => 'sometimes|boolean'
        ]);

        // Se for marcado como padrão, desmarca outros do mesmo segmento
        if ($request->padrao) {
            Cardapio::where('segmento_id', $request->segmento_id)
                  ->where('id', '!=', $cardapio->id)
                  ->update(['padrao' => false]);
        }

        $cardapio->update([
            'nome' => $request->nome,
            'escola_id' => $request->escola_id,
            'segmento_id' => $request->segmento_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'observacoes' => $request->observacoes,
            'ativo' => $request->ativo ?? false,
            'padrao' => $request->padrao ?? false
        ]);

        // Sincronizar alimentos com dias e refeições
        $alimentosSync = [];
        foreach ($request->alimentos as $alimentoId) {
            $alimentosSync[$alimentoId] = [
                'dia_semana' => $request->input("dia_semana_$alimentoId"),
                'refeicao' => $request->input("refeicao_$alimentoId")
            ];
        }

        $cardapio->alimentos()->sync($alimentosSync);

        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio atualizado com sucesso!');
    }

    public function destroy(Cardapio $cardapio)
    {
        $cardapio->delete();
        return redirect()->route('cardapios.index')
                         ->with('success', 'Cardápio excluído com sucesso!');
    }

    public function toggleStatus(Cardapio $cardapio)
    {
        $cardapio->update(['ativo' => !$cardapio->ativo]);
        return response()->json(['success' => true, 'ativo' => $cardapio->ativo]);
    }

    public function togglePadrao(Cardapio $cardapio)
    {
        // Se estiver marcando como padrão, desmarca outros do mesmo segmento
        if (!$cardapio->padrao) {
            Cardapio::where('segmento_id', $cardapio->segmento_id)
                  ->where('id', '!=', $cardapio->id)
                  ->update(['padrao' => false]);
        }

        $cardapio->update(['padrao' => !$cardapio->padrao]);
        return response()->json(['success' => true, 'padrao' => $cardapio->padrao]);
    }

    public function generatePdf(Cardapio $cardapio)
    {
        $pdf = PDF::loadView('cardapios.pdf', compact('cardapio'))
                 ->setPaper('a4', 'landscape');
        
        return $pdf->download("cardapio_{$cardapio->escola->nome}_{$cardapio->segmento->nome}.pdf");
    }

    public function generateAllPdfs(Request $request)
    {
        $request->validate([
            'escola_id' => 'required|exists:escolas,id',
            'segmento_id' => 'required|exists:segmentos,id'
        ]);

        $cardapios = Cardapio::where('escola_id', $request->escola_id)
                            ->where('segmento_id', $request->segmento_id)
                            ->with(['alimentos', 'escola', 'segmento'])
                            ->get();

        if ($cardapios->isEmpty()) {
            return back()->with('error', 'Nenhum cardápio encontrado para os critérios selecionados.');
        }

        $pdf = PDF::loadView('cardapios.all_pdfs', compact('cardapios'))
                 ->setPaper('a4', 'landscape');
        
        return $pdf->download("cardapios_{$cardapios->first()->escola->nome}_{$cardapios->first()->segmento->nome}.pdf");
    }
}