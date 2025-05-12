@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">Criar Novo Cardápio</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cardapios.index') }}">Cardápios</a></li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('cardapios.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Informações do Cardápio</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cardapios.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome do Cardápio*</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="escola_id" class="form-label">Escola*</label>
                        <select class="form-select @error('escola_id') is-invalid @enderror" 
                                id="escola_id" name="escola_id" required>
                            <option value="">Selecione a escola...</option>
                            @foreach($escolas as $escola)
                                <option value="{{ $escola->id }}" {{ old('escola_id') == $escola->id ? 'selected' : '' }}>
                                    {{ $escola->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('escola_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="segmento_id" class="form-label">Segmento*</label>
                        <select class="form-select @error('segmento_id') is-invalid @enderror" 
                                id="segmento_id" name="segmento_id" required>
                            <option value="">Selecione o segmento...</option>
                            @foreach($segmentos as $segmento)
                                <option value="{{ $segmento->id }}" {{ old('segmento_id') == $segmento->id ? 'selected' : '' }}>
                                    {{ $segmento->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('segmento_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_inicio" class="form-label">Data Início*</label>
                        <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" 
                               id="data_inicio" name="data_inicio" value="{{ old('data_inicio') }}" required>
                        @error('data_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="data_fim" class="form-label">Data Fim*</label>
                        <input type="date" class="form-control @error('data_fim') is-invalid @enderror" 
                               id="data_fim" name="data_fim" value="{{ old('data_fim') }}" required>
                        @error('data_fim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alimentos*</label>
                    <div class="row">
                        @foreach($alimentos as $alimento)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       id="alimento_{{ $alimento->id }}" 
                                       name="alimentos[]" value="{{ $alimento->id }}"
                                       {{ in_array($alimento->id, old('alimentos', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="alimento_{{ $alimento->id }}">
                                    {{ $alimento->nome }} ({{ $alimento->unidade_medida }})
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('alimentos')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Salvar Cardápio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection