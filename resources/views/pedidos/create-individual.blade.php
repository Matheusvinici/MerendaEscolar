@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Novo Pedido Individual</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="escola_id">Escola</label>
                            <select name="escola_id" id="escola_id" class="form-control" required>
                                <option value="">Selecione a escola</option>
                                @foreach($escolas as $escola)
                                <option value="{{ $escola->id }}">
                                    {{ $escola->nome }} 
                                    (Creche: {{ $escola->alunos->first()->creche_parcial + $escola->alunos->first()->creche_integral }},
                                    Pré: {{ $escola->alunos->first()->pre_parcial + $escola->alunos->first()->pre_integral }},
                                    Fund: {{ $escola->alunos->first()->fundamental_parcial + $escola->alunos->first()->fundamental_integral }},
                                    EJA: {{ $escola->alunos->first()->eja }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_inicio">Data Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_fim">Data Fim</label>
                            <input type="date" name="data_fim" id="data_fim" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mb-4">
                    <h5>Alimentos Disponíveis</h5>
                    <div class="row">
                        @foreach($alimentos->chunk(4) as $chunk)
                        <div class="col-md-3">
                            <ul>
                                @foreach($chunk as $alimento)
                                <li>{{ $alimento->nome }} ({{ $alimento->unidade_medida }})</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Confirmar Pedido
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