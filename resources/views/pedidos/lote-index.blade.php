@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-clipboard-list mr-2"></i>Gestão de Pedidos
                </h2>
                <div>
                    <a href="{{ route('pedidos.create') }}" class="btn btn-light btn-lg mr-2">
                        <i class="fas fa-plus-circle mr-2"></i>Pedido Individual
                    </a>
                    <a href="{{ route('pedidos.lote.create') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-layer-group mr-2"></i>Pedido em Lote
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-borderless">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="border-0"><i class="fas fa-hashtag mr-2"></i>Lote ID</th>
                            <th class="border-0"><i class="fas fa-calendar-alt mr-2"></i>Data</th>
                            <th class="border-0"><i class="fas fa-school mr-2"></i>Qtd Escolas</th>
                            <th class="border-0"><i class="fas fa-clock mr-2"></i>Período</th>
                            <th class="border-0 text-center"><i class="fas fa-cogs mr-2"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotes as $lote)
                        @php
                            $pedidos = \App\Models\Pedido::where('lote_id', $lote->lote_id)->get();
                            $primeiroPedido = $pedidos->first();
                        @endphp
                        <tr class="border-bottom">
                            <td class="align-middle">
                                <span class="badge badge-primary p-2">#{{ $lote->lote_id }}</span>
                            </td>
                            <td class="align-middle">
                                <i class="far fa-calendar text-primary mr-2"></i>
                                {{ $lote->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-info p-2">
                                    <i class="fas fa-school mr-1"></i> {{ $pedidos->count() }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span><i class="far fa-calendar-check text-primary mr-2"></i> {{ $primeiroPedido->data_inicio->format('d/m/Y') }}</span>
                                    <span><i class="far fa-calendar-times text-primary mr-2"></i> {{ $primeiroPedido->data_fim->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                   
                                    <a href="{{ route('pedidos.lote.pdf', ['lote' => $lote->lote_id, 'tipo' => 'consolidado']) }}" 
                                       class="btn btn-outline-success btn-sm rounded-pill"
                                       data-toggle="tooltip" title="Gerar PDF consolidado">
                                        <i class="fas fa-book mr-1"></i> Consolidado
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $lotes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(45, 206, 137, 0.1);
    }
    .card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    .btn-outline-primary {
        border-width: 2px;
    }
    .btn-outline-success {
        border-width: 2px;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection