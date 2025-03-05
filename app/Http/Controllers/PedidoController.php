<?php
namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Escola;
use App\Models\Proposta;
use App\Models\Alimento;
use App\Models\PropostaAlimento;
use Illuminate\Http\Request;
use PDF;

class PedidoController extends Controller
{
    /**
     * Exibe a lista de pedidos.
     */
    public function index()
    {
        $pedidos = Pedido::with(['escola', 'proposta', 'alimento'])
            ->orderBy('data_pedido', 'desc')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Exibe o formulário para criar pedidos em lote.
     */
    public function create()
    {
        $alimentos = Alimento::all();
        return view('pedidos.create', compact('alimentos'));
    }

    /**
     * Processa a criação de pedidos em lote.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alimento_id' => 'required|exists:alimentos,id',
            'dias_pedido' => 'required|integer|min:1',
            'data_pedido' => 'required|date',
            'data_entrega' => 'required|date|after_or_equal:data_pedido',
        ]);

        $alimento = Alimento::find($request->alimento_id);
        $diasPedido = $request->dias_pedido;
        $dataPedido = $request->data_pedido;
        $dataEntrega = $request->data_entrega;

        // Calcula a quantidade total necessária de alimentos para todas as escolas
        $escolas = Escola::with('bairro.regiao')->get();
        $quantidadeTotal = 0;

        foreach ($escolas as $escola) {
            $quantidadeTotal += $this->calcularQuantidadePorEscola($escola, $alimento, $diasPedido);
        }

        // Distribui a quantidade total entre os agricultores aprovados
        $propostasAprovadas = PropostaAlimento::where('alimento_id', $alimento->id)
            ->whereHas('proposta', function ($query) {
                $query->where('status', 'aprovada');
            })
            ->get();

        $quantidadeDisponivel = $propostasAprovadas->sum('quantidade_aprovada');

        if ($quantidadeTotal > $quantidadeDisponivel) {
            return redirect()->back()->with('error', 'Quantidade de alimentos insuficiente para atender a demanda.');
        }

        // Gera os pedidos em lote
        foreach ($escolas as $escola) {
            $quantidadeEscola = $this->calcularQuantidadePorEscola($escola, $alimento, $diasPedido);

            foreach ($propostasAprovadas as $proposta) {
                if ($quantidadeEscola <= 0) break;

                $quantidadePedida = min($quantidadeEscola, $proposta->quantidade_aprovada);

                Pedido::create([
                    'escola_id' => $escola->id,
                    'proposta_id' => $proposta->proposta_id,
                    'alimento_id' => $alimento->id,
                    'quantidade_pedida' => $quantidadePedida,
                    'data_pedido' => $dataPedido,
                    'data_entrega' => $dataEntrega,
                ]);

                $quantidadeEscola -= $quantidadePedida;
                $proposta->quantidade_aprovada -= $quantidadePedida;
                $proposta->save();
            }
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedidos gerados com sucesso!');
    }

    /**
     * Calcula a quantidade necessária de alimentos para uma escola.
     */
    private function calcularQuantidadePorEscola(Escola $escola, Alimento $alimento, $diasPedido)
    {
        $quantidade = 0;

        if ($escola->pre_escola_alunos && $alimento->pre_escola_qtd) {
            $quantidade += $escola->pre_escola_alunos * $alimento->pre_escola_qtd * $diasPedido;
        }

        if ($escola->fundamental_alunos && $alimento->fundamental_qtd) {
            $quantidade += $escola->fundamental_alunos * $alimento->fundamental_qtd * $diasPedido;
        }

        if ($escola->eja_alunos && $alimento->eja_qtd) {
            $quantidade += $escola->eja_alunos * $alimento->eja_qtd * $diasPedido;
        }

        return $quantidade / 1000; // Converte de gramas para kg
    }

    /**
     * Gera um PDF com os pedidos da semana.
     */
    public function gerarPdf()
    {
        $pedidos = Pedido::with(['escola', 'proposta', 'alimento'])
            ->whereBetween('data_pedido', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $pdf = PDF::loadView('pedidos.pdf', compact('pedidos'));
        return $pdf->download('pedidos-semana.pdf');
    }
}