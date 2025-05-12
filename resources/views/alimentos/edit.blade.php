@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 font-weight-bold">
                    <i class="fas fa-edit mr-2"></i>Editar Alimento
                </h2>
                <a href="{{ route('alimentos.show', $alimento->id) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('alimentos.update', $alimento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="form-label text-primary">Nome do Alimento*</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" name="nome" value="{{ old('nome', $alimento->nome) }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unidade_medida" class="form-label text-primary">Unidade de Medida*</label>
                            <select class="form-control @error('unidade_medida') is-invalid @enderror" 
                                    id="unidade_medida" name="unidade_medida" required>
                                <option value="">Selecione...</option>
                                <option value="KG" {{ old('unidade_medida', $alimento->unidade_medida) == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                                <option value="maço" {{ old('unidade_medida', $alimento->unidade_medida) == 'maço' ? 'selected' : '' }}>Maço</option>
                                <option value="unidade" {{ old('unidade_medida', $alimento->unidade_medida) == 'unidade' ? 'selected' : '' }}>Unidade</option>
                                <option value="litro" {{ old('unidade_medida', $alimento->unidade_medida) == 'litro' ? 'selected' : '' }}>Litro</option>
                            </select>
                            @error('unidade_medida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-weight mr-2"></i>Quantidade Per Capita
                        </h5>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="creche_parcial_per_capita" class="form-label">Creche Parcial*</label>
                            <div class="input-group">
                                <input type="number" step="0.001" class="form-control @error('creche_parcial_per_capita') is-invalid @enderror" 
                                       id="creche_parcial_per_capita" name="creche_parcial_per_capita" 
                                       value="{{ old('creche_parcial_per_capita', $alimento->creche_parcial_per_capita) }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $alimento->unidade_medida }}/aluno</span>
                                </div>
                                @error('creche_parcial_per_capita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pre_integral_per_capita" class="form-label">Pré Integral*</label>
                            <div class="input-group">
                                <input type="number" step="0.001" class="form-control @error('pre_integral_per_capita') is-invalid @enderror" 
                                       id="pre_integral_per_capita" name="pre_integral_per_capita" 
                                       value="{{ old('pre_integral_per_capita', $alimento->pre_integral_per_capita) }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $alimento->unidade_medida }}/aluno</span>
                                </div>
                                @error('pre_integral_per_capita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fundamental_parcial_per_capita" class="form-label">Fund. Parcial*</label>
                            <div class="input-group">
                                <input type="number" step="0.001" class="form-control @error('fundamental_parcial_per_capita') is-invalid @enderror" 
                                       id="fundamental_parcial_per_capita" name="fundamental_parcial_per_capita" 
                                       value="{{ old('fundamental_parcial_per_capita', $alimento->fundamental_parcial_per_capita) }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $alimento->unidade_medida }}/aluno</span>
                                </div>
                                @error('fundamental_parcial_per_capita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fundamental_integral_per_capita" class="form-label">Fund. Integral*</label>
                            <div class="input-group">
                                <input type="number" step="0.001" class="form-control @error('fundamental_integral_per_capita') is-invalid @enderror" 
                                       id="fundamental_integral_per_capita" name="fundamental_integral_per_capita" 
                                       value="{{ old('fundamental_integral_per_capita', $alimento->fundamental_integral_per_capita) }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $alimento->unidade_medida }}/aluno</span>
                                </div>
                                @error('fundamental_integral_per_capita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-calendar-alt mr-2"></i>Incidências
                        </h5>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="incidencia_creche_parcial" class="form-label">Creche Parcial*</label>
                            <input type="number" step="0.01" class="form-control @error('incidencia_creche_parcial') is-invalid @enderror" 
                                   id="incidencia_creche_parcial" name="incidencia_creche_parcial" 
                                   value="{{ old('incidencia_creche_parcial', $alimento->incidencia_creche_parcial) }}" required>
                            @error('incidencia_creche_parcial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="incidencia_pre_integral" class="form-label">Pré Integral*</label>
                            <input type="number" step="0.01" class="form-control @error('incidencia_pre_integral') is-invalid @enderror" 
                                   id="incidencia_pre_integral" name="incidencia_pre_integral" 
                                   value="{{ old('incidencia_pre_integral', $alimento->incidencia_pre_integral) }}" required>
                            @error('incidencia_pre_integral')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="incidencia_fundamental_parcial" class="form-label">Fund. Parcial*</label>
                            <input type="number" step="0.01" class="form-control @error('incidencia_fundamental_parcial') is-invalid @enderror" 
                                   id="incidencia_fundamental_parcial" name="incidencia_fundamental_parcial" 
                                   value="{{ old('incidencia_fundamental_parcial', $alimento->incidencia_fundamental_parcial) }}" required>
                            @error('incidencia_fundamental_parcial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="incidencia_fundamental_integral" class="form-label">Fund. Integral*</label>
                            <input type="number" step="0.01" class="form-control @error('incidencia_fundamental_integral') is-invalid @enderror" 
                                   id="incidencia_fundamental_integral" name="incidencia_fundamental_integral" 
                                   value="{{ old('incidencia_fundamental_integral', $alimento->incidencia_fundamental_integral) }}" required>
                            @error('incidencia_fundamental_integral')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ativo" name="ativo" 
                                       {{ old('ativo', $alimento->ativo) ? 'checked' : '' }}>
                                <label class="custom-control-label text-primary" for="ativo">Alimento Ativo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-2"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(87deg, #1171ef 0, #11cdef 100%) !important;
    }
    
    .text-primary {
        color: #1171ef !important;
    }
    
    .form-control, .custom-select {
        border-radius: 0.5rem;
    }
    
    .input-group-text {
        background-color: #e9ecef;
        color: #495057;
    }
    
    .custom-switch .custom-control-label::before {
        border-radius: 0.5rem;
        height: 1.25rem;
        top: 0.15rem;
    }
    
    .custom-switch .custom-control-label::after {
        border-radius: 50%;
        height: calc(1.25rem - 4px);
        width: calc(1.25rem - 4px);
        top: calc(0.15rem + 2px);
    }
    
    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 1.1rem;
        border-radius: 0.5rem;
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
</style>
@endsection