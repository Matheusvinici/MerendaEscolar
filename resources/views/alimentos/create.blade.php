@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white rounded-top">
            <h4 class="m-0 font-weight-bold">Cadastrar Novo Alimento</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alimentos.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome do Alimento <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                   id="nome" name="nome" value="{{ old('nome') }}" required
                                   placeholder="Ex: Arroz Branco">
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="unidade_medida" class="form-label">Unidade de Medida <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                            <select class="form-select @error('unidade_medida') is-invalid @enderror"
                                     id="unidade_medida" name="unidade_medida" required>
                                <option value="" disabled {{ old('unidade_medida') == '' ? 'selected' : '' }}>Selecione...</option>
                                <option value="KG" {{ old('unidade_medida') == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                                <option value="maço" {{ old('unidade_medida') == 'maço' ? 'selected' : '' }}>Maço</option>
                                <option value="unidade" {{ old('unidade_medida') == 'unidade' ? 'selected' : '' }}>Unidade</option>
                                <option value="litro" {{ old('unidade_medida') == 'litro' ? 'selected' : '' }}>Litro</option>
                            </select>
                            @error('unidade_medida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="creche_parcial_per_capita" class="form-label">Creche Parcial (kg/aluno) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-baby"></i></span>
                            <input type="number" step="0.001" class="form-control @error('creche_parcial_per_capita') is-invalid @enderror"
                                   id="creche_parcial_per_capita" name="creche_parcial_per_capita"
                                   value="{{ old('creche_parcial_per_capita', 0) }}" required
                                   placeholder="0,000">
                            @error('creche_parcial_per_capita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="pre_integral_per_capita" class="form-label">Pré Integral (kg/aluno) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-child"></i></span>
                            <input type="number" step="0.001" class="form-control @error('pre_integral_per_capita') is-invalid @enderror"
                                   id="pre_integral_per_capita" name="pre_integral_per_capita"
                                   value="{{ old('pre_integral_per_capita', 0) }}" required
                                   placeholder="0,000">
                            @error('pre_integral_per_capita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="fundamental_parcial_per_capita" class="form-label">Fund. Parcial (kg/aluno) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                            <input type="number" step="0.001" class="form-control @error('fundamental_parcial_per_capita') is-invalid @enderror"
                                   id="fundamental_parcial_per_capita" name="fundamental_parcial_per_capita"
                                   value="{{ old('fundamental_parcial_per_capita', 0) }}" required
                                   placeholder="0,000">
                            @error('fundamental_parcial_per_capita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="fundamental_integral_per_capita" class="form-label">Fund. Integral (kg/aluno) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            <input type="number" step="0.001" class="form-control @error('fundamental_integral_per_capita') is-invalid @enderror"
                                   id="fundamental_integral_per_capita" name="fundamental_integral_per_capita"
                                   value="{{ old('fundamental_integral_per_capita', 0) }}" required
                                   placeholder="0,000">
                            @error('fundamental_integral_per_capita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="incidencia_creche_parcial" class="form-label">Incidência Creche Parcial (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            <input type="number" step="0.01" class="form-control @error('incidencia_creche_parcial') is-invalid @enderror"
                                   id="incidencia_creche_parcial" name="incidencia_creche_parcial"
                                   value="{{ old('incidencia_creche_parcial', 0) }}" required
                                   placeholder="0,00">
                            @error('incidencia_creche_parcial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="incidencia_pre_integral" class="form-label">Incidência Pré Integral (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            <input type="number" step="0.01" class="form-control @error('incidencia_pre_integral') is-invalid @enderror"
                                   id="incidencia_pre_integral" name="incidencia_pre_integral"
                                   value="{{ old('incidencia_pre_integral', 0) }}" required
                                   placeholder="0,00">
                            @error('incidencia_pre_integral')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="incidencia_fundamental_parcial" class="form-label">Incidência Fund. Parcial (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            <input type="number" step="0.01" class="form-control @error('incidencia_fundamental_parcial') is-invalid @enderror"
                                   id="incidencia_fundamental_parcial" name="incidencia_fundamental_parcial"
                                   value="{{ old('incidencia_fundamental_parcial', 0) }}" required
                                   placeholder="0,00">
                            @error('incidencia_fundamental_parcial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="incidencia_fundamental_integral" class="form-label">Incidência Fund. Integral (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            <input type="number" step="0.01" class="form-control @error('incidencia_fundamental_integral') is-invalid @enderror"
                                   id="incidencia_fundamental_integral" name="incidencia_fundamental_integral"
                                   value="{{ old('incidencia_fundamental_integral', 0) }}" required
                                   placeholder="0,00">
                            @error('incidencia_fundamental_integral')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('alimentos.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cadastrar Alimento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection