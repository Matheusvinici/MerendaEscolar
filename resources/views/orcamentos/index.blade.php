@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Orçamentos Cadastrados</h2>
        <a href="{{ route('orcamentos.create') }}" class="btn btn-dark">Cadastrar Orçamento</a>
    </div>

    @if(session('total'))
        <div class="alert alert-success">
            <strong>Total de Custo Calculado:</strong> R$ {{ number_format(session('total'), 2, ',', '.') }}
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Descrição</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Total de Custo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamentos as $orcamento)
                <tr>
                    <td>{{ $orcamento->descricao }}</td>
                    <td>{{ \Carbon\Carbon::parse($orcamento->data_inicio)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($orcamento->data_fim)->format('d/m/Y') }}</td>                    <td>
                        @php
                            $totalCusto = 0;
                            foreach ($orcamento->alimentos as $alimento) {
                                $totalCusto += $alimento->pivot->custo_total;
                            }
                        @endphp
                        R$ {{ number_format($totalCusto, 2, ',', '.') }}
                    </td>
                    <td>
                        <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('orcamentos.edit', $orcamento->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
