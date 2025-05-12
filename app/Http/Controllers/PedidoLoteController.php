<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Escola;
use App\Models\Pedido;
use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PedidoLoteController extends Controller
{
   

    public function index()
    {
        $lotes = Pedido::whereNotNull('lote_id')
                      ->select('lote_id', DB::raw('MIN(created_at) as created_at'))
                      ->groupBy('lote_id')
                      ->orderByDesc('created_at')
                      ->paginate(10);
        
        return view('pedidos.lote-index', compact('lotes'));
    }

    public function create()
    {
        $escolas = Escola::with(['alunos' => function($query) {
            $query->where('ano_letivo', date('Y'));
        }])->has('alunos')->get();

        // Filtra escolas que realmente têm alunos
        $escolas = $escolas->filter(function($escola) {
            return $escola->alunos->isNotEmpty();
        });

        $alimentos = Alimento::where('ativo', true)->get();
        
        return view('pedidos.create-lote', compact('escolas', 'alimentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'escolas' => 'required|array|min:1',
            'escolas.*' => 'exists:escolas,id',
            'alimentos' => 'required|array|min:1',
            'alimentos.*' => 'exists:alimentos,id',
        ]);

        $alimentos = Alimento::whereIn('id', $request->alimentos)->get();
        $escolas = Escola::with(['alunos' => function($query) {
            $query->where('ano_letivo', date('Y'));
        }])->whereIn('id', $request->escolas)->get();

        $loteId = now()->format('YmdHis');

        DB::transaction(function() use ($request, $escolas, $alimentos, $loteId) {
            foreach ($escolas as $escola) {
                $pedido = Pedido::create([
                    'escola_id' => $escola->id,
                    'data_inicio' => $request->data_inicio,
                    'data_fim' => $request->data_fim,
                    'user_id' => auth()->id(),
                    'lote_id' => $loteId,
                    'status' => 'concluido'
                ]);

                foreach ($escola->alunos as $aluno) {
                    foreach ($alimentos as $alimento) {
                        $total = $this->calcularQuantidade($aluno, $alimento);

                        if ($total > 0) {
                            $pedido->itens()->create([
                                'alimento_id' => $alimento->id,
                                'quantidade' => $total,
                                'unidade_medida' => $alimento->unidade_medida,
                                'incidencia_creche_parcial' => $alimento->incidencia_creche_parcial,
                                'incidencia_creche_integral' => $alimento->incidencia_creche_integral,
                                'incidencia_pre_parcial' => $alimento->incidencia_pre_parcial,
                                'incidencia_pre_integral' => $alimento->incidencia_pre_integral,
                                'incidencia_fundamental_parcial' => $alimento->incidencia_fundamental_parcial,
                                'incidencia_fundamental_integral' => $alimento->incidencia_fundamental_integral,
                                'incidencia_eja' => $alimento->incidencia_eja,
                                'valor_unitario' => $alimento->preco,
                                'valor_total' => $total * $alimento->preco
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('pedidos.lote.index')
               ->with('success', 'Pedido em lote criado com sucesso!');
    }

    public function gerarPdf($loteId, $tipo)
    {
        $pedidos = Pedido::with(['escola.alunos', 'itens.alimento'])
                        ->where('lote_id', $loteId)
                        ->get();
    
        if ($tipo === 'individual') {
            $zip = new \ZipArchive();
            $zipName = storage_path("app/pedidos_lote_{$loteId}.zip");
    
            if ($zip->open($zipName, \ZipArchive::CREATE) === TRUE) {
                foreach ($pedidos as $pedido) {
                    $pdf = PDF::loadView('pedidos.ficha-entrega', compact('pedido'))
                             ->setPaper('a4', 'portrait');
                    $zip->addFromString("ficha_entrega_{$pedido->escola->nome}.pdf", $pdf->output());
                }
                $zip->close();
    
                return response()->download($zipName)->deleteFileAfterSend(true);
            }
            abort(500, 'Erro ao criar arquivo ZIP');
        } else {
            $pdf = PDF::loadView('pedidos.pdf-lote', compact('pedidos'))
                     ->setPaper('a4', 'portrait');
    
            return $pdf->download("fichas_entrega_lote_{$loteId}.pdf");
        }
    }
    

    private function calcularQuantidade($aluno, $alimento)
    {
        $total = 0;
        $total += $aluno->creche_parcial * $alimento->creche_parcial_per_capita * $alimento->incidencia_creche_parcial;
        $total += $aluno->creche_integral * $alimento->creche_integral_per_capita * $alimento->incidencia_creche_integral;
        $total += $aluno->pre_parcial * $alimento->pre_parcial_per_capita * $alimento->incidencia_pre_parcial;
        $total += $aluno->pre_integral * $alimento->pre_integral_per_capita * $alimento->incidencia_pre_integral;
        $total += $aluno->fundamental_parcial * $alimento->fundamental_parcial_per_capita * $alimento->incidencia_fundamental_parcial;
        $total += $aluno->fundamental_integral * $alimento->fundamental_integral_per_capita * $alimento->incidencia_fundamental_integral;
        $total += $aluno->eja * $alimento->eja_per_capita * $alimento->incidencia_eja;

        return round($total, 3);
    }

    private function calcularTotaisEscola($escola, $alimentos)
    {
        $aluno = $escola->alunos->first();
        $totais = [
            'creche' => 0,
            'pre' => 0,
            'fundamental' => 0,
            'eja' => 0,
            'total' => 0
        ];

        foreach ($alimentos as $alimento) {
            $quantidade = $this->calcularQuantidade($aluno, $alimento);
            
            $totais['creche'] += ($aluno->creche_parcial * $alimento->creche_parcial_per_capita * $alimento->incidencia_creche_parcial) +
                                ($aluno->creche_integral * $alimento->creche_integral_per_capita * $alimento->incidencia_creche_integral);
            $totais['pre'] += ($aluno->pre_parcial * $alimento->pre_parcial_per_capita * $alimento->incidencia_pre_parcial) +
                             ($aluno->pre_integral * $alimento->pre_integral_per_capita * $alimento->incidencia_pre_integral);
            $totais['fundamental'] += ($aluno->fundamental_parcial * $alimento->fundamental_parcial_per_capita * $alimento->incidencia_fundamental_parcial) +
                                     ($aluno->fundamental_integral * $alimento->fundamental_integral_per_capita * $alimento->incidencia_fundamental_integral);
            $totais['eja'] += $aluno->eja * $alimento->eja_per_capita * $alimento->incidencia_eja;
            $totais['total'] += $quantidade;
        }

        return $totais;
    }

    private function calcularTotaisPedido($pedido)
    {
        $aluno = $pedido->escola->alunos->first();
        
        return [
            'creche' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->creche_parcial * $item->alimento->creche_parcial_per_capita * $item->incidencia_creche_parcial) + 
                       ($aluno->creche_integral * $item->alimento->creche_integral_per_capita * $item->incidencia_creche_integral);
            }),
            'pre' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->pre_parcial * $item->alimento->pre_parcial_per_capita * $item->incidencia_pre_parcial) + 
                       ($aluno->pre_integral * $item->alimento->pre_integral_per_capita * $item->incidencia_pre_integral);
            }),
            'fundamental' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->fundamental_parcial * $item->alimento->fundamental_parcial_per_capita * $item->incidencia_fundamental_parcial) + 
                       ($aluno->fundamental_integral * $item->alimento->fundamental_integral_per_capita * $item->incidencia_fundamental_integral);
            }),
            'eja' => $pedido->itens->sum(function($item) use ($aluno) {
                return $aluno->eja * $item->alimento->eja_per_capita * $item->incidencia_eja;
            }),
            'total' => $pedido->itens->sum('quantidade'),
            'valor_total' => $pedido->itens->sum('valor_total')
        ];
    }
}