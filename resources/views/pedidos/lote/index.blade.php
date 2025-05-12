@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Pedidos em Lote</h2>
            <a href="{{ route('pedidos.lote.create') }}" class="btn btn-light">
                <i class="fas fa-plus-circle"></i> Novo Pedido em Lote
            </a>
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
                            <th>Lote ID</th>
                            <th>Data</th>
                            <th>Escolas</th>
                            <th>Período</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $lote)
                        @php
                            $pedidosLote = \App\Models\Pedido::where('lote_id', $lote->lote_id)->get();
                        @endphp
                        <tr>
                            <td>#{{ $lote->lote_id }}</td>
                            <td>{{ $lote->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $pedidosLote->count() }}</td>
                            <td>
                                {{ $pedidosLote->first()->data_inicio->format('d/m/Y') }}<br>
                                até<br>
                                {{ $pedidosLote->first()->data_fim->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="badge bg-success">Concluído</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pedidos.lote.gerar', ['lote' => $lote->lote_id, 'tipo' => 'unico']) }}" 
                                       class="btn btn-sm btn-info" title="PDF Único">
                                        <i class="fas fa-book"></i>
                                    </a>
                                    <a href="{{ route('pedidos.lote.gerar', ['lote' => $lote->lote_id, 'tipo' => 'separado']) }}" 
                                       class="btn btn-sm btn-primary" title="PDFs Separados">
                                        <i class="fas fa-file-archive"></i>
                                    </a>
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