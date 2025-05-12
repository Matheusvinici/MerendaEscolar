@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-gradient">Lista de Alunos por Segmento</h2>
            <p class="text-muted">Visualização consolidada dos alunos matriculados</p>
        </div>
        <a href="{{ route('alunos.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>Nova Escola
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th class="ps-4 ">Escola</th>
                        
                        <th>Ano</th>
                        <th class="text-center ">Creche P.</th>
                        <th class="text-center ">Creche I.</th>
                        <th class="text-center ">Pré P.</th>
                        <th class="text-center ">Pré I.</th>
                        <th class="text-center ">Fund. P.</th>
                        <th class="text-center ">Fund. I.</th>
                        <th class="text-center ">EJA</th>
                        <th class="text-center  fw-bold">Total</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alunos as $aluno)
                    <tr class="border-top">
                        <td class="ps-4 fw-medium">{{ $aluno->escola->nome }}</td>
                        <td>{{ $aluno->ano_letivo }}</td>
                        <td class="text-center">{{ $aluno->creche_parcial }}</td>
                        <td class="text-center">{{ $aluno->creche_integral }}</td>
                        <td class="text-center">{{ $aluno->pre_parcial }}</td>
                        <td class="text-center">{{ $aluno->pre_integral }}</td>
                        <td class="text-center">{{ $aluno->fundamental_parcial }}</td>
                        <td class="text-center">{{ $aluno->fundamental_integral }}</td>
                        <td class="text-center">{{ $aluno->eja }}</td>
                        <td class="text-center fw-bold text-primary">
                            {{ $aluno->creche_parcial + $aluno->creche_integral + $aluno->pre_parcial + $aluno->pre_integral + $aluno->fundamental_parcial + $aluno->fundamental_integral + $aluno->eja }}
                        </td>
                        <td class="pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('alunos.show', $aluno->id) }}" class="btn btn-sm btn-outline-info rounded-circle" title="Visualizar" data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Editar" data-bs-toggle="tooltip">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Excluir" data-bs-toggle="tooltip" onclick="return confirm('Tem certeza que deseja excluir?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">
                            <i class="fas fa-database me-2"></i>Nenhum registro encontrado
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #1976D2 0%, #0D47A1 100%);
    }
    
    .text-gradient {
        background: -webkit-linear-gradient(135deg, #1976D2, #0D47A1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(25, 118, 210, 0.05);
    }
    
    .rounded-circle {
        width: 2.25rem;
        height: 2.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    // Ativa tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endpush