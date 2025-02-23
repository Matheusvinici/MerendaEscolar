@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Alimento</h2>
    <form action="{{ route('alimentos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Unidade de Medida</label>
            <select name="unidade_medida" class="form-control" required>
                <option value="grama">Grama</option>
                <option value="ml">Mililitro</option>
            </select>
        </div>

        <div class="row">
            @foreach (['pre_escola' => 'Pré-escola', 'fundamental' => 'Fundamental', 'eja' => 'EJA'] as $key => $label)
            <div class="col-md-4">
                <div class="mb-3">
                    <h4>{{ $label }}</h4>
                    <label class="form-label">Quantidade por aluno</label>
                    <input type="number" name="{{ $key }}_qtd" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total de alunos</label>
                    <input type="number" name="{{ $key }}_alunos" class="form-control" required>
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
