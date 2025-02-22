@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Editar Alimento</h1>

    <form action="{{ route('alimentos.update', $alimento->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mb-3">
        <!-- Nome do Alimento -->
        <div class="col-md-6">
            <label for="nome" class="form-label text-primary">Nome do Alimento</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $alimento->nome) }}" required>
        </div>

        <!-- Valor Médio -->
        <div class="col-md-6">
            <label for="valor_medio" class="form-label text-primary">Valor Médio (R$)</label>
            <input type="number" step="0.01" class="form-control" id="valor_medio" name="valor_medio" value="{{ old('valor_medio', $alimento->valor_medio) }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Unidade de Medida -->
        <div class="col-md-6">
            <label for="unidade_medida" class="form-label text-primary">Unidade de Medida</label>
            <select name="unidade_medida" class="form-control" required>
                <option value="kg" {{ old('unidade_medida', $alimento->unidade_medida) == 'kg' ? 'selected' : '' }}>Kg</option>
                <option value="litro" {{ old('unidade_medida', $alimento->unidade_medida) == 'litro' ? 'selected' : '' }}>Litro</option>
                <option value="unidade" {{ old('unidade_medida', $alimento->unidade_medida) == 'unidade' ? 'selected' : '' }}>Unidade</option>
                <!-- Adicione outras unidades conforme necessário -->
            </select>
        </div>

        <!-- Periodicidade -->
        <div class="col-md-6">
            <label for="periodicidade" class="form-label text-primary">Periodicidade</label>
            <select name="periodicidade" class="form-control" required>
                <option value="semanal" {{ old('periodicidade', $alimento->periodicidade) == 'semanal' ? 'selected' : '' }}>Semanal</option>
                <option value="mensal" {{ old('periodicidade', $alimento->periodicidade) == 'mensal' ? 'selected' : '' }}>Mensal</option>
            </select>
        </div>
    </div>

    <!-- Especificação do Produto -->
    <div class="mb-3">
        <label for="especificacao" class="form-label text-primary">Especificação do Produto</label>
        <textarea class="form-control" id="especificacao" name="especificacao" required>{{ old('especificacao', $alimento->especificacao) }}</textarea>
    </div>

    <!-- Botão de Submissão -->
    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
</form>

</div>
@endsection
