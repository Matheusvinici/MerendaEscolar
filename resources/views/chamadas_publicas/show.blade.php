@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes da Chamada Pública</h1>

    <div class="card shadow-sm p-4">
        <h3 class="fw-bold">{{ $chamadaPublica->titulo }}</h3>
        <p><strong>Descrição:</strong> {{ $chamadaPublica->descricao }}</p>
        <p><strong>Data de Abertura:</strong> {{ \Carbon\Carbon::parse($chamadaPublica->data_abertura)->format('d/m/Y') }}</p>
        <p><strong>Data de Fechamento:</strong> {{ \Carbon\Carbon::parse($chamadaPublica->data_fechamento)->format('d/m/Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($chamadaPublica->status) }}</p>

        <h4 class="mt-4">Orçamento Associado</h4>
        <p>
            @if($chamadaPublica->orcamentos->isNotEmpty())
                <strong>{{ $chamadaPublica->orcamentos->first()->descricao }}</strong><br>
                <strong>Período:</strong> 
                {{ \Carbon\Carbon::parse($chamadaPublica->orcamentos->first()->data_inicio)->format('d/m/Y') }} até 
                {{ \Carbon\Carbon::parse($chamadaPublica->orcamentos->first()->data_fim)->format('d/m/Y') }}
            @else
                Sem orçamento associado.
            @endif
        </p>

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
                @foreach($chamadaPublica->orcamentos->first()->alimentos ?? [] as $alimento)
                <tr>
                    <td>{{ $alimento->nome }}</td>
                    <td>{{ $alimento->unidade_medida }}</td>
                    <td>R$ {{ number_format($alimento->pivot->valor_medio, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($alimento->pivot->custo_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('chamadas_publicas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        <a href="{{ route('chamadas_publicas.edit', $chamadaPublica) }}" class="btn btn-primary mt-3">Editar</a>
    </div>
</div>
@endsection
