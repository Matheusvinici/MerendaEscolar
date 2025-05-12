@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">Editar Registro</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('alunos.index') }}">Alunos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('alunos.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Atualizar Dados</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="escola_id" class="form-label">Escola*</label>
                        <select class="form-select @error('escola_id') is-invalid @enderror" 
                                id="escola_id" name="escola_id" required>
                            <option value="">Selecione a escola...</option>
                            @foreach($escolas as $escola)
                                <option value="{{ $escola->id }}" {{ $aluno->escola_id == $escola->id ? 'selected' : '' }}>
                                    {{ $escola->nome }} ({{ $escola->codigo_inep }})
                                </option>
                            @endforeach
                        </select>
                        @error('escola_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ano_letivo" class="form-label">Ano Letivo* (AAAA/AAAA)</label>
                        <input type="text" class="form-control @error('ano_letivo') is-invalid @enderror"
                            id="ano_letivo" name="ano_letivo" placeholder="Ex: 2023/2024"
                            value="{{ old('ano_letivo', $aluno->ano_letivo) }}" required maxlength="9">
                        @error('ano_letivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="creche_parcial" class="form-label">Creche Parcial*</label>
                        <input type="number" class="form-control @error('creche_parcial') is-invalid @enderror" 
                               id="creche_parcial" name="creche_parcial" 
                               value="{{ old('creche_parcial', $aluno->creche_parcial) }}" min="0" required>
                        @error('creche_parcial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="creche_integral" class="form-label">Creche Integral*</label>
                        <input type="number" class="form-control @error('creche_integral') is-invalid @enderror" 
                               id="creche_integral" name="creche_integral" 
                               value="{{ old('creche_integral', $aluno->creche_integral) }}" min="0" required>
                        @error('creche_integral')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="pre_parcial" class="form-label">Pré-escolar Parcial*</label>
                        <input type="number" class="form-control @error('pre_parcial') is-invalid @enderror" 
                               id="pre_parcial" name="pre_parcial" 
                               value="{{ old('pre_parcial', $aluno->pre_parcial) }}" min="0" required>
                        @error('pre_parcial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="pre_integral" class="form-label">Pré-escolar Integral*</label>
                        <input type="number" class="form-control @error('pre_integral') is-invalid @enderror" 
                               id="pre_integral" name="pre_integral" 
                               value="{{ old('pre_integral', $aluno->pre_integral) }}" min="0" required>
                        @error('pre_integral')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="fundamental_parcial" class="form-label">Fundamental Parcial*</label>
                        <input type="number" class="form-control @error('fundamental_parcial') is-invalid @enderror" 
                               id="fundamental_parcial" name="fundamental_parcial" 
                               value="{{ old('fundamental_parcial', $aluno->fundamental_parcial) }}" min="0" required>
                        @error('fundamental_parcial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="fundamental_integral" class="form-label">Fundamental Integral*</label>
                        <input type="number" class="form-control @error('fundamental_integral') is-invalid @enderror" 
                               id="fundamental_integral" name="fundamental_integral" 
                               value="{{ old('fundamental_integral', $aluno->fundamental_integral) }}" min="0" required>
                        @error('fundamental_integral')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="eja" class="form-label">EJA*</label>
                        <input type="number" class="form-control @error('eja') is-invalid @enderror" 
                               id="eja" name="eja" 
                               value="{{ old('eja', $aluno->eja) }}" min="0" required>
                        @error('eja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Atualizar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Máscara para o ano letivo (AAAA/AAAA)
    document.addEventListener('DOMContentLoaded', function() {
        const anoLetivoInput = document.getElementById('ano_letivo');
        
        if (anoLetivoInput) {
            anoLetivoInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 4) {
                    value = value.substring(0, 4) + '/' + value.substring(4, 8);
                }
                
                e.target.value = value;
            });
        }
    });
</script>
@endsection
