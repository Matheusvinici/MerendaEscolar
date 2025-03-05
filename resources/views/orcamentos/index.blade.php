@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <!-- Cabeçalho com título e botão alinhados -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Orçamentos Cadastrados</h2>
        <a href="{{ route('orcamentos.create') }}" class="btn btn-dark">
            <i class="fas fa-plus"></i> Cadastrar Orçamento
        </a>
    </div>

    @if(session('total'))
        <div class="alert alert-success">
            <strong>Total de Custo Calculado:</strong> R$ {{ number_format(session('total'), 2, ',', '.') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabela de orçamentos -->
    <div class="table-responsive">
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
                @forelse ($orcamentos as $orcamento)
                    <tr>
                        <td>{{ $orcamento->descricao }}</td>
                        <td>{{ \Carbon\Carbon::parse($orcamento->data_inicio)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($orcamento->data_fim)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $totalCusto = 0;
                                foreach ($orcamento->alimentos as $alimento) {
                                    $totalCusto += $alimento->pivot->custo_total;
                                }
                            @endphp
                            R$ {{ number_format($totalCusto, 2, ',', '.') }}
                        </td>
                        <td>
                            <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('orcamentos.edit', $orcamento->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum orçamento cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Links de paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orcamentos->links() }}
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilos para melhorar a responsividade */
    .table-responsive {
        overflow-x: auto;
    }
    .btn-sm {
        margin: 2px;
    }
    h2 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    th, td {
        text-align: center;
    }
    .btn-dark {
        margin-bottom: 15px;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
    .bg-warning {
        background-color: #ffc107;
    }
    .bg-success {
        background-color: #28a745;
    }
    .bg-danger {
        background-color: #dc3545;
    }
</style>
@endsection