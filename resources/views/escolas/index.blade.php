@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <!-- Cabeçalho com título e botão alinhados -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Escolas</h1>
        <a href="{{ route('escolas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Escola
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabela de escolas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>INEP</th>
                    <th>Bairro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($escolas as $escola)
                    <tr>
                        <td>{{ $escola->id }}</td>
                        <td>{{ $escola->nome }}</td>
                        <td>{{ $escola->inep }}</td>
                        <td>{{ $escola->bairro->nome }}</td>
                        <td>
                            <a href="{{ route('escolas.show', $escola->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('escolas.edit', $escola->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('escolas.destroy', $escola->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="5" class="text-center">Nenhuma escola cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $escolas->links() }}
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