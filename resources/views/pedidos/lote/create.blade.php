@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <h2 class="mb-0">
                <i class="fas fa-layer-group mr-2"></i>Criar Novo Pedido em Lote
            </h2>
        </div>

        <div class="card-body">
            <form action="{{ route('pedidos.lote.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_inicio">Data Início</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_fim">Data Fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Escolas incluídas no lote</label>
                    <small class="text-muted d-block mb-3">Desmarque apenas as escolas que não devem ser incluídas</small>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50px" class="text-center">Incluir</th>
                                    <th>Escola</th>
                                    <th class="text-center">Total de Alunos</th>
                                    <th class="text-center">Creche</th>
                                    <th class="text-center">Pré-Escola</th>
                                    <th class="text-center">Fundamental</th>
                                    <th class="text-center">EJA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($escolas as $escola)
                                @php
                                    $aluno = $escola->alunos->first();
                                    $totalAlunos = ($aluno->creche_parcial + $aluno->creche_integral + 
                                                   $aluno->pre_parcial + $aluno->pre_integral + 
                                                   $aluno->fundamental_parcial + $aluno->fundamental_integral + 
                                                   $aluno->eja);
                                @endphp
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" 
                                                   id="escola_{{ $escola->id }}" 
                                                   name="escolas[]" 
                                                   value="{{ $escola->id }}"
                                                   checked>
                                            <label class="custom-control-label" for="escola_{{ $escola->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ $escola->nome }}</td>
                                    <td class="text-center align-middle font-weight-bold">{{ $totalAlunos }}</td>
                                    <td class="text-center align-middle">{{ $aluno->creche_parcial + $aluno->creche_integral }}</td>
                                    <td class="text-center align-middle">{{ $aluno->pre_parcial + $aluno->pre_integral }}</td>
                                    <td class="text-center align-middle">{{ $aluno->fundamental_parcial + $aluno->fundamental_integral }}</td>
                                    <td class="text-center align-middle">{{ $aluno->eja }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group mt-5">
                    <label class="font-weight-bold">Alimentos incluídos no lote</label>
                    <small class="text-muted d-block mb-3">Desmarque apenas os alimentos que não devem ser incluídos</small>
                    
                    <div class="row">
                        @foreach($alimentos as $alimento)
                        <div class="col-md-4 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" 
                                       id="alimento_{{ $alimento->id }}" 
                                       name="alimentos[]" 
                                       value="{{ $alimento->id }}"
                                       checked>
                                <label class="custom-control-label" for="alimento_{{ $alimento->id }}">
                                    {{ $alimento->nome }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('pedidos.lote.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> Salvar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
    }
    .table thead th {
        vertical-align: middle;
        font-weight: 600;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .custom-checkbox .custom-control-label::before, 
    .custom-checkbox .custom-control-label::after {
        top: 0.25rem;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endsection