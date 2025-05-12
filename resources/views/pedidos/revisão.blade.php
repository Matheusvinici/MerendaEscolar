@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Confirmar Pedido em Lote</h2>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informações do Período</h5>
                    <p><strong>Data Início:</strong> {{ \Carbon\Carbon::parse($dados['data_inicio'])->format('d/m/Y') }}</p>
                    <p><strong>Data Fim:</strong> {{ \Carbon\Carbon::parse($dados['data_fim'])->format('d/m/Y') }}</p>
                    <p><strong>Total de Escolas:</strong> {{ $escolas->count() }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Alimentos Incluídos</h5>
                    <ul class="list-unstyled">
                        @foreach($alimentos as $alimento)
                            <li>{{ $alimento->nome }} ({{ $alimento->unidade_medida }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Escola</th>
                            <th>Creche</th>
                            <th>Pré-Escola</th>
                            <th>Fundamental</th>
                            <th>EJA</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($escolas as $escola)
                            @php
                                $aluno = $escola->alunos->first();
                                $totais = [
                                    'creche' => 0,
                                    'pre' => 0,
                                    'fundamental' => 0,
                                    'eja' => 0,
                                    'total' => 0
                                ];
                                
                                foreach($alimentos as $alimento) {
                                    $totais['creche'] += ($aluno->creche_parcial * $alimento->creche_parcial_per_capita * $alimento->incidencia_creche_parcial) +
                                                         ($aluno->creche_integral * $alimento->creche_integral_per_capita * $alimento->incidencia_creche_integral);
                                    
                                    $totais['pre'] += ($aluno->pre_parcial * $alimento->pre_parcial_per_capita * $alimento->incidencia_pre_parcial) +
                                                      ($aluno->pre_integral * $alimento->pre_integral_per_capita * $alimento->incidencia_pre_integral);
                                    
                                    $totais['fundamental'] += ($aluno->fundamental_parcial * $alimento->fundamental_parcial_per_capita * $alimento->incidencia_fundamental_parcial) +
                                                             ($aluno->fundamental_integral * $alimento->fundamental_integral_per_capita * $alimento->incidencia_fundamental_integral);
                                    
                                    $totais['eja'] += $aluno->eja * $alimento->eja_per_capita * $alimento->incidencia_eja;
                                }
                                
                                $totais['total'] = array_sum($totais);
                            @endphp
                            <tr>
                                <td>{{ $escola->nome }}</td>
                                <td>{{ number_format($totais['creche'], 3) }}</td>
                                <td>{{ number_format($totais['pre'], 3) }}</td>
                                <td>{{ number_format($totais['fundamental'], 3) }}</td>
                                <td>{{ number_format($totais['eja'], 3) }}</td>
                                <td>{{ number_format($totais['total'], 3) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form action="{{ route('pedidos.lote.salvar') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pedidos.lote.create') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Confirmar e Salvar Pedido
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection