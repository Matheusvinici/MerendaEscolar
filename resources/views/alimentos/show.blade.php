@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Detalhes do Alimento</h1>

    <div class="card shadow-sm p-4">
        <h2 class="text-center">{{ $alimento->nome }}</h2>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <strong class="text-primary">Unidade de Medida:</strong>
                <p>{{ $alimento->unidade_medida }}</p>
            </div>

            <div class="col-md-6">
                <strong class="text-primary">Periodicidade:</strong>
                <p>{{ $alimento->periodicidade }}</p>
            </div>
        </div>

        <div class="mb-3">
            <strong class="text-primary">Especificação do Produto:</strong>
            <p>{{ $alimento->especificacao }}</p>
        </div>

        <div class="mb-3">
            <strong class="text-primary">Valor Médio:</strong>
            <p>R$ {{ number_format($alimento->valor_medio, 2, ',', '.') }}</p>
        </div>

        <a href="{{ route('alimentos.index') }}" class="btn btn-secondary">Voltar para a lista</a>
    </div>
</div>
@endsection
