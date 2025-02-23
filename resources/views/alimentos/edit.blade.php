@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Alimento</h2>
    <form action="{{ route('alimentos.update', $alimento->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $alimento->nome) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Unidade de Medida</label>
            <select name="unidade_medida" class="form-control" required>
                <option value="grama" {{ $alimento->unidade_medida == 'grama' ? 'selected' : '' }}>Grama</option>
                <option value="ml" {{ $alimento->unidade_medida == 'ml' ? 'selected' : '' }}>Mililitro</option>
            </select>
        </div>

        <div class="row">
            @foreach (['pre_escola' => 'Pré-escola', 'fundamental' => 'Fundamental', 'eja' => 'EJA'] as $key => $label)
            <div class="col-md-4">
                <div class="mb-3">
                    <h4>{{ $label }}</h4>
                    <label class="form-label">Quantidade por aluno</label>
                    <input type="number" name="{{ $key }}_qtd" class="form-control" value="{{ old($key.'_qtd', $alimento->{$key.'_qtd'}) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total de alunos</label>
                    <input type="number" name="{{ $key }}_alunos" class="form-control" value="{{ old($key.'_alunos', $alimento->{$key.'_alunos'}) }}" required>
                </div>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
