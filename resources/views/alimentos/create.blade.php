@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Cadastrar Novo Alimento</h1>

    <form action="{{ route('alimentos.store') }}" method="POST">
    @csrf
    <div class="row mb-3">
        <!-- Nome do Alimento -->
        <div class="col-md-6">
            <label for="nome" class="form-label text-primary">Nome do Alimento</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <!-- Valor Médio -->
        <div class="col-md-6">
            <label for="valor_medio" class="form-label text-primary">Valor Médio (R$)</label>
            <input type="number" step="0.01" class="form-control" id="valor_medio" name="valor_medio" required>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Unidade de Medida -->
        <div class="col-md-6">
            <label for="unidade_medida" class="form-label text-primary">Unidade de Medida</label>
            <select name="unidade_medida" class="form-control" required>
                <option value="kg">Kg</option>
                <option value="litro">Litro</option>
                <option value="unidade">Unidade</option>
                <!-- Adicione outras unidades conforme necessário -->
            </select>
        </div>

        <!-- Periodicidade -->
        <div class="col-md-6">
            <label for="periodicidade" class="form-label text-primary">Periodicidade</label>
            <select name="periodicidade" class="form-control" required>
                <option value="semanal">Semanal</option>
                <option value="mensal">Mensal</option>
            </select>
        </div>
    </div>

    <!-- Especificação do Produto -->
    <div class="mb-3">
        <label for="especificacao" class="form-label text-primary">Especificação do Produto</label>
        <textarea class="form-control" id="especificacao" name="especificacao" required></textarea>
    </div>

    <!-- Botão de Submissão -->
    <button type="submit" class="btn btn-primary">Cadastrar Alimento</button>
</form>

</div>
@endsection
