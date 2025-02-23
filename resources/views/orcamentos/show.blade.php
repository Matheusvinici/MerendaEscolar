@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes do Orçamento</h1>

    <div class="card shadow-sm p-4">
        <h3 class="fw-bold">{{ $orcamento->descricao }}</h3>
        <p><strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($orcamento->data_inicio)->format('d/m/Y') }}</p>
        <p><strong>Data de Fim:</strong> {{ \Carbon\Carbon::parse($orcamento->data_fim)->format('d/m/Y') }}</p>
        <p><strong>Dias Letivos:</strong> {{ $orcamento->dias_letivos }}</p>
        <p><strong>Total do Orçamento:</strong> R$ {{ number_format($orcamento->total, 2, ',', '.') }}</p>

        <h4 class="mt-4">Alimentos Selecionados</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Unidade</th>
                    <th>Preço Unitário</th>
                    <th>Custo Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orcamento->alimentos as $alimento)
                <tr>
                    <td>{{ $alimento->nome }}</td>
                    <td>{{ $alimento->unidade_medida }}</td>
                    <td>R$ {{ number_format($alimento->pivot->valor_medio, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($alimento->pivot->custo_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        <a href="{{ route('orcamentos.edit', $orcamento) }}" class="btn btn-primary mt-3">Editar</a>
    </div>
</div>
@endsection
