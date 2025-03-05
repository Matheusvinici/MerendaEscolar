<!-- resources/views/propostas/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes da Proposta</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Chamada Pública: {{ $proposta->chamadaPublica->descricao }}</h5>
            <p class="card-text"><strong>Valor Total:</strong> R$ {{ number_format($proposta->valor_total, 2, ',', '.') }}</p>

            <h5 class="mt-4">Alimentos Ofertados</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Quantidade Ofertada</th>
                        <th>Quantidade Aprovada</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposta->alimentos as $alimento)
                        <tr>
                            <td>{{ $alimento->nome }}</td>
                            <td>{{ $alimento->pivot->quantidade_ofertada }} Kg/Litro</td>
                            <td>{{ $alimento->pivot->quantidade_aprovada ?? '0' }} Kg/Litro</td>
                            <td>R$ {{ number_format($alimento->pivot->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('propostas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>
@endsection