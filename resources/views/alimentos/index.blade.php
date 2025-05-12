@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 font-weight-bold">Lista de Alimentos</h2>
                <a href="{{ route('alimentos.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle mr-1"></i> Novo Alimento
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-primary-100 text-primary">
                        <tr>
                            <th>Nome</th>
                            <th>Unidade</th>
                            <th>Incidências</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alimentos as $alimento)
                        <tr>
                            <td class="font-weight-bold">{{ $alimento->nome }}</td>
                            <td>{{ $alimento->unidade_medida }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge badge-primary">CP: {{ $alimento->incidencia_creche_parcial }}x</span>
                                    <span class="badge badge-info">PI: {{ $alimento->incidencia_pre_integral }}x</span>
                                    <span class="badge badge-success">FP: {{ $alimento->incidencia_fundamental_parcial }}x</span>
                                    <span class="badge badge-warning">FI: {{ $alimento->incidencia_fundamental_integral }}x</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('alimentos.toggle-status', $alimento->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $alimento->ativo ? 'btn-success' : 'btn-secondary' }} btn-pill">
                                        <i class="fas {{ $alimento->ativo ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $alimento->ativo ? 'Ativo' : 'Inativo' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('alimentos.show', $alimento->id) }}" class="btn btn-sm btn-info" title="Visualizar">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>
                                    <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                    <form action="{{ route('alimentos.destroy', $alimento->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-utensils fa-2x mb-2"></i>
                                <p>Nenhum alimento cadastrado</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(87deg, #1171ef 0, #11cdef 100%) !important;
    }
    
    .bg-primary-100 {
        background-color: rgba(17, 113, 239, 0.1);
    }
    
    .text-primary {
        color: #1171ef !important;
    }
    
    .btn-pill {
        border-radius: 50rem;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(17, 113, 239, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endsection