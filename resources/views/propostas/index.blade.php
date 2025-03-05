<!-- resources/views/propostas/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Minhas Propostas</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botão para criar proposta -->
    <div class="mb-3">
        <a href="{{ route('propostas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Criar Proposta
        </a>
    </div>

    <!-- Tabela de propostas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Chamada Pública</th>
                    <th>Valor Total</th>
                    <th>Região</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($propostas as $proposta)
                    <tr>
                        <td>{{ $proposta->chamadaPublica->titulo }}</td>
                        @foreach ($proposta->alimentos as $alimento)
                            <td>R$ {{ number_format($alimento->pivot->valor_total, 2, ',', '.') }}</td>
                        @endforeach
                                    <td>{{ $proposta->regiao->nome }}</td>
                        <td>
                            @if ($proposta->status === 'pendente')
                                <span class="badge bg-warning">Pendente</span>
                            @elseif ($proposta->status === 'aprovada')
                                <span class="badge bg-success">Aprovada</span>
                            @elseif ($proposta->status === 'reprovada')
                                <span class="badge bg-danger">Reprovada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma proposta cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $propostas->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilos para melhorar a responsividade */
    .table-responsive {
        overflow-x: auto;
    }
    .btn-sm {
        margin: 2px;
    }
    h1 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    th, td {
        text-align: center;
    }
    .btn-success {
        margin-bottom: 15px;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
    .bg-warning {
        background-color: #ffc107;
    }
    .bg-success {
        background-color: #28a745;
    }
    .bg-danger {
        background-color: #dc3545;
    }
</style>
@endsection