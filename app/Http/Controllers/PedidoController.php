<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Escola;
use App\Models\Pedido;
use App\Models\Alimento;
use Illuminate\Http\Request;
use PDF;

class PedidoController extends Controller
{
    public function index()
    {
        $lotes = Pedido::with(['escola', 'itens'])
                      ->whereNotNull('lote_id')
                      ->select('lote_id', \DB::raw('MIN(created_at) as created_at'))
                      ->groupBy('lote_id')
                      ->orderByDesc('created_at')
                      ->paginate(10);
        
        return view('pedidos.lote-index', compact('lotes'));
    }
    
    public function create()
    {
        $escolas = Escola::has('alunos')->with('alunos')->get();
        $alimentos = Alimento::where('disponivel', true)->get();
        
        return view('pedidos.create-individual', compact('escolas', 'alimentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'escola_id' => 'required|exists:escolas,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio'
        ]);

        $escola = Escola::with('alunos')->find($request->escola_id);
        $aluno = $escola->alunos->first();
        $alimentos = Alimento::where('disponivel', true)->get();

        $pedido = Pedido::create([
            'escola_id' => $escola->id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'user_id' => auth()->id(),
            'status' => 'concluido'
        ]);

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
                ]);
            }
        }

        return redirect()->route('pedidos.index')
               ->with('success', 'Pedido individual criado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['escola.alunos', 'itens.alimento']);
        $totais = $this->calcularTotais($pedido);
        
        return view('pedidos.show', compact('pedido', 'totais'));
    }

    public function gerarPdf(Pedido $pedido)
    {
        $pedido->load(['escola.alunos', 'itens.alimento']);
        $totais = $this->calcularTotais($pedido);
        
        $pdf = PDF::loadView('pedidos.pdf-individual', compact('pedido', 'totais'))
                 ->setPaper('a4', 'portrait');

        return $pdf->download("pedido_{$pedido->id}.pdf");
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

    private function calcularTotais($pedido)
    {
        $aluno = $pedido->escola->alunos->first();
        
        return [
            'creche' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->creche_parcial * $item->incidencia_creche_parcial) + 
                       ($aluno->creche_integral * $item->incidencia_creche_integral);
            }),
            'pre' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->pre_parcial * $item->incidencia_pre_parcial) + 
                       ($aluno->pre_integral * $item->incidencia_pre_integral);
            }),
            'fundamental' => $pedido->itens->sum(function($item) use ($aluno) {
                return ($aluno->fundamental_parcial * $item->incidencia_fundamental_parcial) + 
                       ($aluno->fundamental_integral * $item->incidencia_fundamental_integral);
            }),
            'eja' => $pedido->itens->sum(function($item) use ($aluno) {
                return $aluno->eja * $item->incidencia_eja;
            }),
            'total' => $pedido->itens->sum('quantidade')
        ];
    }
}