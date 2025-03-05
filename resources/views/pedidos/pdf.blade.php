<!DOCTYPE html>
<html>
<head>
    <title>Pedidos da Semana</title>
</head>
<body>
    <h1>Pedidos da Semana</h1>
    <table>
        <thead>
            <tr>
                <th>Escola</th>
                <th>Alimento</th>
                <th>Quantidade (kg)</th>
                <th>Data do Pedido</th>
                <th>Data de Entrega</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->escola->nome }}</td>
                <td>{{ $pedido->propostaAlimento->alimento->nome }}</td>
                <td>{{ $pedido->quantidade_pedida }}</td>
                <td>{{ $pedido->data_pedido }}</td>
                <td>{{ $pedido->data_entrega }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>