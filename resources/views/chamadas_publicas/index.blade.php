@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <!-- Cabeçalho com título e botão alinhados -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Chamadas Públicas</h2>
        <a href="{{ route('chamadas_publicas.create') }}" class="btn btn-dark">
            <i class="fas fa-plus"></i> Registrar Chamada Pública
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabela de chamadas públicas -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Título</th>
                    <th>Data de Abertura</th>
                    <th>Data de Fechamento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($chamadasPublicas as $chamadaPublica)
                    <tr>
                        <td>{{ $chamadaPublica->titulo }}</td>
                        <td>{{ \Carbon\Carbon::parse($chamadaPublica->data_abertura)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($chamadaPublica->data_fechamento)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($chamadaPublica->status) }}</td>
                        <td>
                            <a href="{{ route('chamadas_publicas.show', $chamadaPublica->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('chamadas_publicas.edit', $chamadaPublica->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('chamadas_publicas.destroy', $chamadaPublica->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="5" class="text-center">Nenhuma chamada pública cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $chamadasPublicas->links() }}
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
    h2 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    th, td {
        text-align: center;
    }
    .btn-dark {
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