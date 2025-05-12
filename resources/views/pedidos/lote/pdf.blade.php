<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedido #{{ $pedido->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .total { font-weight: bold; text-align: right; margin-top: 20px; }
        .footer { margin-top: 50px; font-size: 0.8em; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pedido de Alimentação Escolar</h2>
        <h3>{{ $pedido->escola->nome }}</h3>
    </div>

    <div class="info">
        <p><strong>Período:</strong> {{ $pedido->data_inicio->format('d/m/Y') }} a {{ $pedido->data_fim->format('d/m/Y') }}</p>
        @if($pedido->cardapio)
            <p><strong>Cardápio de referência:</strong> {{ $pedido->cardapio->nome }}</p>
        @endif
        <p><strong>Gerado em:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        @if($pedido->observacoes)
            <p><strong>Observações:</strong> {{ $pedido->observacoes }}</p>
        @endif
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
                    <td>R$ {{ number_format($item->valor_unitario, 2) }}</td>
                    <td>R$ {{ number_format($item->valor_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total do Pedido: R$ {{ number_format($pedido->itens->sum('valor_total'), 2) }}</p>
    </div>

    <div class="footer">
        <p>Sistema de Gestão de Alimentação Escolar</p>
        <p>Gerado por: {{ $pedido->usuario->name }}</p>
    </div>
</body>
</html>