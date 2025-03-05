@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pedidos</h1>
    <a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-3">Criar Pedidos em Lote</a>
    <table class="table">
        <thead>
            <tr>
                <th>Escola</th>
                <th>Alimento</th>
                <th>Quantidade Pedida (kg)</th>
                <th>Data do Pedido</th>
                <th>Data de Entrega</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->escola->nome }}</td>
                <td>{{ $pedido->alimento->nome }}</td>
                <td>{{ $pedido->quantidade_pedida }}</td>
                <td>{{ $pedido->data_pedido }}</td>
                <td>{{ $pedido->data_entrega }}</td>
                <td>
                    <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pedidos->links() }}
</div>
@endsection