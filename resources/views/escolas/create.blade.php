@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Cadastrar Nova Escola</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('escolas.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="nome" class="form-label">Nome da Escola*</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="codigo_inep" class="form-label">Código INEP*</label>
                        <input type="text" class="form-control @error('codigo_inep') is-invalid @enderror" 
                               id="codigo_inep" name="codigo_inep" value="{{ old('codigo_inep') }}" required>
                        @error('codigo_inep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('escolas.index') }}" class="btn btn-secondary me-md-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cadastrar Escola
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection