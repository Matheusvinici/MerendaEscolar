@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bairros</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botão para criar novo bairro -->
    <div class="mb-3">
        <a href="{{ route('bairros.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Novo Bairro
        </a>
    </div>

    <!-- Tabela de bairros -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Região</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bairros as $bairro)
                    <tr>
                        <td>{{ $bairro->id }}</td>
                        <td>{{ $bairro->nome }}</td>
                        <td>{{ $bairro->regiao->nome }}</td>
                        <td>
                            <a href="{{ route('bairros.show', $bairro->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('bairros.edit', $bairro->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('bairros.destroy', $bairro->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="4" class="text-center">Nenhum bairro cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $bairros->links() }}
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