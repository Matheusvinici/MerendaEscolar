@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Gerar Pedidos em Lote</h2>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pedidos.lote.preparar') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_inicio">Data Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_fim">Data Fim</label>
                            <input type="date" name="data_fim" id="data_fim" class="form-control" required>
                        </div>
                    </div>
                </div>

                

                <div class="alert alert-info mb-4">
                    <h5 class="alert-heading">Alimentos Disponíveis para esta Quinzena</h5>
                    <div class="row">
                        @foreach ($alimentosDisponiveis->chunk(4) as $chunk)
                            <div class="col-md-3">
                                <ul class="mb-0">
                                    @foreach ($chunk as $alimento)
                                        <li>{{ $alimento->nome }} ({{ $alimento->unidade_medida }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Continuar para Revisão
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validação das datas
        const dataInicio = document.getElementById('data_inicio');
        const dataFim = document.getElementById('data_fim');
        
        dataInicio.addEventListener('change', function() {
            if (dataInicio.value && dataFim.value && dataFim.value < dataInicio.value) {
                alert('A data final deve ser posterior à data inicial');
                dataFim.value = '';
            }
        });
        
        dataFim.addEventListener('change', function() {
            if (dataInicio.value && dataFim.value && dataFim.value < dataInicio.value) {
                alert('A data final deve ser posterior à data inicial');
                dataFim.value = '';
            }
        });
    });
</script>
@endsection
@endsection