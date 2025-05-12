@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recebimentos Registrados</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Escola</th>
                        <th>Pedido</th>
                        <th>Data Recebimento</th>
                        <th>Atraso</th>
                        <th>Qualidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recebimentos as $recebimento)
                    <tr>
                        <td>{{ $recebimento->id }}</td>
                        <td>{{ $recebimento->escola->nome }}</td>
                        <td>#{{ $recebimento->pedido->id }}</td>
                        <td>{{ $recebimento->data_recebimento->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($recebimento->atraso_minutos)
                                <span class="badge badge-warning">{{ $recebimento->atraso_minutos }} min</span>
                            @else
                                <span class="badge badge-success">No prazo</span>
                            @endif
                        </td>
                        <td>
                            @if($recebimento->qualidade_avaliacao)
                                @php
                                    $colors = [
                                        1 => 'danger',
                                        2 => 'warning',
                                        3 => 'info',
                                        4 => 'primary',
                                        5 => 'success'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $colors[$recebimento->qualidade_avaliacao] }}">
                                    {{ $recebimento->qualidade_avaliacao }}
                                </span>
                            @else
                                <span class="badge badge-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('recebimentos.show', $recebimento->id) }}" class="btn btn-sm btn-primary">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $recebimentos->links() }}
        </div>
    </div>
</div>
@endsection