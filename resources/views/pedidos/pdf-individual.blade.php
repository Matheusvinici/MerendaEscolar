<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedido - {{ $pedido->escola->nome }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 5px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .total { margin-top: 15px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 0.8em; text-align: center; }
        .segmentos { margin-bottom: 15px; }
        .segmentos table { width: 100%; border-collapse: collapse; }
        .segmentos th, .segmentos td { border: 1px solid #ddd; padding: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pedido de Alimentação Escolar</h2>
        <h3>{{ $pedido->escola->nome }}</h3>
        <p>Período: {{ $pedido->data_inicio->format('d/m/Y') }} a {{ $pedido->data_fim->format('d/m/Y') }}</p>
    </div>

    <div class="segmentos">
        <h4>Quantidade de Alunos por Segmento</h4>
        <table>
            <thead>
                <tr>
                    <th>Creche</th>
                    <th>Pré-Escola</th>
                    <th>Fundamental</th>
                    <th>EJA</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totais['creche'] }}</td>
                    <td>{{ $totais['pre'] }}</td>
                    <td>{{ $totais['fundamental'] }}</td>
                    <td>{{ $totais['eja'] }}</td>
                    <td>{{ $totais['total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Alimento</th>
                <th>Quantidade</th>
                <th>Unidade</th>
                <th>Valor Unitário</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->itens as $item)
                <tr>
                    <td>{{ $item->alimento->nome }}</td>
                    <td>{{ number_format($item->quantidade, 3) }}</td>
                    <td>{{ $item->unidade_medida }}</td>
                    <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total do Pedido: R$ {{ number_format($pedido->itens->sum('valor_total'), 2, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Sistema de Gestão de Alimentação Escolar</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>