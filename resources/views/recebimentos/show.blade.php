@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes do Recebimento</h1>
        <a href="{{ route('recebimentos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Informações Gerais</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Escola:</strong> {{ $recebimento->escola->nome }}</p>
                    <p><strong>Pedido:</strong> #{{ $recebimento->pedido->id }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Data do Recebimento:</strong> {{ $recebimento->data_recebimento->format('d/m/Y H:i') }}</p>
                    <p><strong>Registrado por:</strong> {{ $recebimento->usuario->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Atraso:</strong> {{ $recebimento->atraso_minutos ? $recebimento->atraso_minutos . ' minutos' : 'Nenhum' }}</p>
                    <p><strong>Avaliação Qualidade:</strong> 
                        @if($recebimento->qualidade_avaliacao)
                            {{ $recebimento->qualidade_avaliacao }} - 
                            @switch($recebimento->qualidade_avaliacao)
                                @case(1) Péssima @break
                                @case(2) Ruim @break
                                @case(3) Regular @break
                                @case(4) Boa @break
                                @case(5) Excelente @break
                            @endswitch
                        @else
                            Não avaliado
                        @endif
                    </p>
                </div>
            </div>
            
            @if($recebimento->observacoes)
                <div class="mt-3">
                    <strong>Observações Gerais:</strong>
                    <p>{{ $recebimento->observacoes }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Itens Recebidos</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Previsto</th>
                        <th>Recebido</th>
                        <th>Diferença</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recebimento->itens as $item)
                    <tr>
                        <td>{{ $item->itemPedido->alimento->nome }} ({{ $item->itemPedido->unidade_medida }})</td>
                        <td>{{ number_format($item->quantidade_prevista, 3, ',', '.') }}</td>
                        <td>{{ number_format($item->quantidade_recebida, 3, ',', '.') }}</td>
                        <td class="{{ $item->diferenca > 0 ? 'text-success' : ($item->diferenca < 0 ? 'text-danger' : '') }}">
                            {{ number_format($item->diferenca, 3, ',', '.') }}
                        </td>
                        <td>{{ $item->observacoes }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($recebimento->qualidade_observacoes || $recebimento->anexos->count())
    <div class="card mb-4">
        <div class="card-header">Qualidade dos Alimentos</div>
        <div class="card-body">
            @if($recebimento->qualidade_observacoes)
                <div class="mb-3">
                    <strong>Observações sobre a Qualidade:</strong>
                    <p>{{ $recebimento->qualidade_observacoes }}</p>
                </div>
            @endif
            
            @if($recebimento->anexos->count())
                <div>
                    <strong>Anexos:</strong>
                    <div class="row mt-3">
                        @foreach($recebimento->anexos as $anexo)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                @if(in_array($anexo->tipo, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ Storage::url($anexo->caminho_arquivo) }}" class="card-img-top" alt="Anexo">
                                @else
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                    </div>
                                @endif
                                <div class="card-footer p-2">
                                    <a href="{{ route('recebimentos.download.anexo', $anexo->id) }}" 
                                       class="btn btn-sm btn-primary" download>
                                        Baixar
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection