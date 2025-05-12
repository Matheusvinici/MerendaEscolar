@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 font-weight-bold">
                    <i class="fas fa-utensils mr-2"></i>Detalhes do Alimento
                </h2>
                <div>
                    <a href="{{ route('alimentos.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Informações Básicas -->
                <div class="col-md-6">
                    <div class="info-card mb-4">
                        <h5 class="info-card-header bg-primary-100 text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Informações Básicas
                        </h5>
                        <div class="info-card-body">
                            <div class="info-item">
                                <span class="info-label">Nome:</span>
                                <span class="info-value">{{ $alimento->nome }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Unidade de Medida:</span>
                                <span class="info-value">{{ $alimento->unidade_medida }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                <span class="badge badge-{{ $alimento->ativo ? 'success' : 'secondary' }}">
                                    {{ $alimento->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Per Capita -->
                <div class="col-md-6">
                    <div class="info-card mb-4">
                        <h5 class="info-card-header bg-primary-100 text-primary">
                            <i class="fas fa-weight mr-2"></i>Quantidade Per Capita
                        </h5>
                        <div class="info-card-body">
                            <div class="info-item">
                                <span class="info-label">Creche Parcial:</span>
                                <span class="info-value">{{ number_format($alimento->creche_parcial_per_capita, 3) }} {{ $alimento->unidade_medida }}/aluno</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Pré Integral:</span>
                                <span class="info-value">{{ number_format($alimento->pre_integral_per_capita, 3) }} {{ $alimento->unidade_medida }}/aluno</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fundamental Parcial:</span>
                                <span class="info-value">{{ number_format($alimento->fundamental_parcial_per_capita, 3) }} {{ $alimento->unidade_medida }}/aluno</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fundamental Integral:</span>
                                <span class="info-value">{{ number_format($alimento->fundamental_integral_per_capita, 3) }} {{ $alimento->unidade_medida }}/aluno</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incidências -->
            <div class="row">
                <div class="col-md-12">
                    <div class="info-card">
                        <h5 class="info-card-header bg-primary-100 text-primary">
                            <i class="fas fa-calendar-alt mr-2"></i>Incidências
                        </h5>
                        <div class="info-card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="incidence-card">
                                        <div class="incidence-value bg-primary text-white">
                                            {{ $alimento->incidencia_creche_parcial }}x
                                        </div>
                                        <div class="incidence-label">Creche Parcial</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="incidence-card">
                                        <div class="incidence-value bg-info text-white">
                                            {{ $alimento->incidencia_pre_integral }}x
                                        </div>
                                        <div class="incidence-label">Pré Integral</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="incidence-card">
                                        <div class="incidence-value bg-success text-white">
                                            {{ $alimento->incidencia_fundamental_parcial }}x
                                        </div>
                                        <div class="incidence-label">Fundamental Parcial</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="incidence-card">
                                        <div class="incidence-value bg-warning text-white">
                                            {{ $alimento->incidencia_fundamental_integral }}x
                                        </div>
                                        <div class="incidence-label">Fundamental Integral</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="text-muted">
                        <i class="fas fa-calendar mr-1"></i>
                        Criado em: {{ $alimento->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div>
                    <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-warning mr-2">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                    <form action="{{ route('alimentos.destroy', $alimento->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este alimento?')">
                            <i class="fas fa-trash-alt mr-1"></i> Excluir
                        </button>
                    </form>
                </div>
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
    
    .info-card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .info-card-header {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-weight: 600;
    }
    
    .info-card-body {
        padding: 1.25rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #6c757d;
    }
    
    .info-value {
        color: #343a40;
    }
    
    .incidence-card {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .incidence-value {
        font-size: 1.5rem;
        font-weight: 700;
        padding: 1rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .incidence-label {
        background-color: #f8f9fa;
        padding: 0.5rem;
        border-radius: 0 0 0.5rem 0.5rem;
        font-weight: 600;
    }
    
    .card-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
@endsection