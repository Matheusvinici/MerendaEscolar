@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Alimentos</h2>
        <a href="{{ route('alimentos.create') }}" class="btn btn-dark">
            <i class="fas fa-plus"></i> Registrar Alimento
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabela de alimentos -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Alimento</th>
                    <th>Unidade de Medida</th>
                    <th>Total (kg/L)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alimentos as $alimento)
                    <tr>
                        <td>{{ $alimento->nome }}</td>
                        <td>{{ $alimento->unidade_medida }}</td>
                        <td>{{ $alimento->total_kg_litro }}</td> <!-- Exibe o valor calculado no controlador -->
                        <td>
                            <a href="{{ route('alimentos.show', $alimento->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('alimentos.destroy', $alimento->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="4" class="text-center">Nenhum alimento cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $alimentos->links() }}
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