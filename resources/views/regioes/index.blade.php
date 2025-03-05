@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Regiões</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botão para criar nova região -->
    <div class="mb-3">
        <a href="{{ route('regioes.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Região
        </a>
    </div>

    <!-- Tabela de regiões -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($regioes as $regiao)
                    <tr>
                        <td>{{ $regiao->id }}</td>
                        <td>{{ $regiao->nome }}</td>
                        <td>
                            <a href="{{ route('regioes.show', $regiao->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('regioes.edit', $regiao->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('regioes.destroy', $regiao->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhuma região cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $regioes->links() }}
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