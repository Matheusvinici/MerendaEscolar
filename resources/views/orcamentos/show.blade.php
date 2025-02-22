@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Detalhes do Orçamento</h1>
        <a href="{{ route('orcamentos.index') }}" class="btn btn-primary d-flex align-items-center">
            <span class="me-2">←</span> Voltar
        </a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title"><strong>Nome do Orçamento:</strong> {{ $orcamento->descricao }}</h4>
            <br>
            <p class="text-muted"><strong>Valor Total:</strong> R$ {{ number_format($orcamento->total_estimado, 2, ',', '.') }}</p>
        </div>
    </div>

    <h3 class="text-secondary">Alimentos no Orçamento</h3>
    <table class="table table-striped">
        <thead style="background-color: #1D3C6A; color: white;">
            <tr>
                <th>Nome</th>
                <th>Unidade de Medida</th>
                <th>Quantidade</th>
                <th>Valor Unitário (R$)</th>
                <th>Valor Total (R$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orcamento->alimentos as $alimento)
                <tr>
                    <td>{{ $alimento->nome }}</td>
                    <td>{{ $alimento->unidade_medida }}</td>
                    <td>{{ $alimento->pivot->quantidade }}</td>
                    <td>R$ {{ number_format($alimento->pivot->valor_unitario, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($alimento->pivot->valor_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
