@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Todos os Pedidos</h2>
            <div>
                <a href="{{ route('pedidos.create') }}" class="btn btn-light me-2">
                    <i class="fas fa-plus"></i> Individual
                </a>
                <a href="{{ route('pedidos.lote.create') }}" class="btn btn-outline-light">
                    <i class="fas fa-layer-group"></i> Em Lote
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Escola</th>
                            <th>Tipo</th>
                            <th>Período</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        @php
                            $totais = app('App\Http\Controllers\PedidoController')->calcularTotais($pedido);
                        @endphp
                        <tr>
                            <td>#{{ $pedido->id }}</td>
                            <td>{{ $pedido->escola->nome }}</td>
                            <td>
                                @if($pedido->lote_id)
                                    <span class="badge bg-info">Lote {{ $pedido->lote_id }}</span>
                                @else
                                    <span class="badge bg-secondary">Individual</span>
                                @endif
                            </td>
                            <td>
                                {{ $pedido->data_inicio->format('d/m/Y') }}<br>
                                até<br>
                                {{ $pedido->data_fim->format('d/m/Y') }}
                            </td>
                            <td>{{ number_format($totais['total'], 3) }} kg</td>
                            <td>
                                <span class="badge bg-{{ $pedido->status == 'concluido' ? 'success' : 'warning' }}">
                                    {{ ucfirst($pedido->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pedidos.gerarPdf', $pedido->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    @if($pedido->lote_id)
                                        <a href="{{ route('pedidos.lote.pdf', ['lote' => $pedido->lote_id, 'tipo' => 'consolidado']) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-book"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $pedidos->links() }}
        </div>
    </div>
</div>
@endsection