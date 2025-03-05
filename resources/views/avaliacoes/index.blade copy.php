@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Propostas Pendentes</h1>

    <!-- Filtro por Região -->
    <form action="{{ route('avaliacoes.index') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="regiao">Filtrar por Região:</label>
            <select name="regiao_id" id="regiao" class="form-control">
                <option value="">Todas as Regiões</option>
                @foreach ($regioes as $regiao)
                    <option value="{{ $regiao->id }}" {{ request('regiao_id') == $regiao->id ? 'selected' : '' }}>
                        {{ $regiao->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Tabela de Necessidades por Região -->
    @foreach ($necessidadesPorRegiao as $regiaoId => $dados)
        <h2 class="mt-5">Região: {{ $dados['regiao'] }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Alimento</th>
                    <th>Necessário (kg/litro)</th>
                    <th>Ofertado (kg/litro)</th>
                    <th>Diferença (kg/litro)</th>
                    <th>Total Aprovado (kg/litro)</th> <!-- Nova coluna -->
                </tr>
            </thead>
            <tbody>
                @foreach ($dados['necessidades'] as $alimentoId => $alimento)
                    <tr>
                        <td>{{ $alimento['nome'] }}</td>
                        <td>{{ $alimento['total_necessario'] }}</td>
                        <td>{{ $alimento['total_ofertado'] }}</td>
                        <td>{{ $alimento['total_necessario'] - $alimento['total_ofertado'] }}</td>
                        <td>{{ $alimento['total_aprovado'] }}</td> <!-- Nova coluna -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    
    <!-- Tabela de Propostas Pendentes -->
    <h2 class="mt-5">Propostas Pendentes</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Chamada Pública</th>
                <th>Região</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($propostas as $proposta)
                <tr>
                    <td>{{ $proposta->id }}</td>
                    <td>{{ $proposta->chamadaPublica->titulo }}</td>
                    <td>{{ $proposta->regiao->nome }}</td>
                    <td>R$ {{ number_format($proposta->valor_total, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('avaliacoes.create', ['proposta' => $proposta->id]) }}" class="btn btn-primary">
    Avaliar Proposta
</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

  <!-- Tabela de Resumo de Alimentos -->
<h2 class="mt-5">Resumo de Alimentos</h2>
<table class="table">
    <thead>
        <tr>
            <th>Alimento</th>
            <th>Total Ofertado (kg)</th>
            <th>Limite da Chamada (kg)</th>
            <th>Disponível (kg)</th>
            <th>Total Aprovado (kg)</th>
            <th>% Aprovado</th> <!-- Nova coluna -->
        </tr>
    </thead>
    <tbody>
        @foreach ($alimentosTotais as $alimentoId => $alimento)
            <tr>
                <td>{{ $alimento['nome'] }}</td>
                <td>{{ $alimento['total_kg'] }}</td>
                <td>{{ $alimento['limite_chamada'] }}</td>
                <td>{{ $alimento['limite_chamada'] - $alimento['total_kg'] }}</td>
                <td>{{ $alimento['total_aprovado'] }}</td>
                <td>
                    @if ($alimento['total_kg'] > 0)
                        {{ number_format(($alimento['total_aprovado'] / $alimento['total_kg']) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    <!-- Botão para Distribuir Propostas -->
    <form action="{{ route('avaliacoes.distribuir') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Distribuir Propostas</button>
    </form>
</div>
@endsection