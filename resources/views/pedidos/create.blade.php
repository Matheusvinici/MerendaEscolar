@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Pedidos em Lote</h1>
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="alimento_id">Alimento</label>
            <select name="alimento_id" id="alimento_id" class="form-control" required>
                @foreach ($alimentos as $alimento)
                <option value="{{ $alimento->id }}">{{ $alimento->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="dias_pedido">Dias do Pedido</label>
            <input type="number" name="dias_pedido" id="dias_pedido" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="data_pedido">Data do Pedido</label>
            <input type="date" name="data_pedido" id="data_pedido" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="data_entrega">Data de Entrega</label>
            <input type="date" name="data_entrega" id="data_entrega" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Gerar Pedidos</button>
    </form>
</div>
@endsection