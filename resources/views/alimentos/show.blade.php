@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes do Alimento</h1>

    <div class="card shadow-sm p-4">
        <h3 class="fw-bold">{{ $alimento->nome }}</h3>
        <p><strong>Unidade de Medida:</strong> {{ ucfirst($alimento->unidade_medida) }}</p>

        <div class="row">
            @foreach (['pre_escola' => 'Pré-escola', 'fundamental' => 'Fundamental', 'eja' => 'EJA'] as $key => $label)
            <div class="col-md-4">
                <h4>{{ $label }}</h4>
                <p><strong>Quantidade por aluno:</strong> {{ $alimento->{$key.'_qtd'} }}</p>
                <p><strong>Total de alunos:</strong> {{ $alimento->{$key.'_alunos'} }}</p>
            </div>
            @endforeach
        </div>

        <a href="{{ route('alimentos.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        <a href="{{ route('alimentos.edit', $alimento) }}" class="btn btn-primary mt-3">Editar</a>
    </div>
</div>
@endsection
