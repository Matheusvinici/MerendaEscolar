<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Recebimento;
use App\Models\RecebimentoItem;
use App\Models\RecebimentoAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecebimentoController extends Controller
{
    public function index()
    {
        $recebimentos = Recebimento::with(['pedido', 'escola'])
            ->orderByDesc('data_recebimento')
            ->paginate(10);

        return view('recebimentos.index', compact('recebimentos'));
    }

    public function create($pedidoId)
    {
        $pedido = Pedido::with(['escola', 'itens.alimento'])->findOrFail($pedidoId);
        
        return view('recebimentos.create', compact('pedido'));
    }

    public function store(Request $request, $pedidoId)
    {
        $pedido = Pedido::with('itens')->findOrFail($pedidoId);

        $request->validate([
            'data_recebimento' => 'required|date',
            'atraso_minutos' => 'nullable|integer',
            'qualidade_avaliacao' => 'nullable|integer|min:1|max:5',
            'qualidade_observacoes' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'itens.*.quantidade_recebida' => 'required|numeric|min:0',
            'itens.*.observacoes' => 'nullable|string',
            'anexos.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $recebimento = Recebimento::create([
            'pedido_id' => $pedido->id,
            'escola_id' => $pedido->escola_id,
            'user_id' => auth()->id(),
            'data_recebimento' => $request->data_recebimento,
            'status' => 'concluido',
            'atraso_minutos' => $request->atraso_minutos,
            'qualidade_avaliacao' => $request->qualidade_avaliacao,
            'qualidade_observacoes' => $request->qualidade_observacoes,
            'observacoes' => $request->observacoes,
        ]);

        // Salvar itens recebidos
        foreach ($pedido->itens as $item) {
            $quantidadeRecebida = $request->input("itens.{$item->id}.quantidade_recebida");
            
            RecebimentoItem::create([
                'recebimento_id' => $recebimento->id,
                'item_pedido_id' => $item->id,
                'quantidade_prevista' => $item->quantidade,
                'quantidade_recebida' => $quantidadeRecebida,
                'diferenca' => $quantidadeRecebida - $item->quantidade,
                'observacoes' => $request->input("itens.{$item->id}.observacoes"),
            ]);
        }

        // Salvar anexos
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('recebimentos/anexos');
                
                RecebimentoAnexo::create([
                    'recebimento_id' => $recebimento->id,
                    'caminho_arquivo' => $path,
                    'tipo' => $file->getClientOriginalExtension(),
                    'descricao' => 'Anexo qualidade - ' . $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('recebimentos.show', $recebimento->id)
            ->with('success', 'Recebimento registrado com sucesso!');
    }

    public function show($id)
    {
        $recebimento = Recebimento::with([
            'pedido', 
            'escola', 
            'itens.itemPedido.alimento', 
            'anexos',
            'usuario'
        ])->findOrFail($id);

        return view('recebimentos.show', compact('recebimento'));
    }

    public function downloadAnexo($id)
    {
        $anexo = RecebimentoAnexo::findOrFail($id);
        
        if (!Storage::exists($anexo->caminho_arquivo)) {
            abort(404);
        }

        return Storage::download($anexo->caminho_arquivo);
    }
}