@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Orçamento</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('orcamentos.update', $orcamento->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campo de Descrição -->
            <div class="mb-4">
                <label for="descricao" class="form-label fw-bold">Descrição do Orçamento</label>
                <input type="text" name="descricao" class="form-control" value="{{ old('descricao', $orcamento->descricao) }}" required>
            </div>

            <!-- Tabela de Alimentos no Orçamento -->
            <h4 class="mb-3">Alimentos no Orçamento</h4>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Unidade de Medida</th>
                        <th>Valor Unitário (R$)</th>
                        <th>Quantidade</th>
                        <th>Valor Total (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->alimentos as $alimento)
                        <tr>
                            <td>{{ $alimento->nome }}</td>

                            <!-- Campo para Editar Unidade de Medida -->
                            <td>
                                <input type="text" name="alimentos[{{ $alimento->pivot->id }}][unidade_medida]" value="{{ old('alimentos.' . $alimento->pivot->id . '.unidade_medida', $alimento->pivot->unidade_medida) }}" class="form-control">
                            </td>

                            <!-- Campo para Editar Valor Unitário -->
                            <td>
                                <input type="number" name="alimentos[{{ $alimento->pivot->id }}][valor_unitario]" value="{{ old('alimentos.' . $alimento->pivot->id . '.valor_unitario', $alimento->pivot->valor_unitario) }}" class="form-control" step="0.01" min="0">
                            </td>

                            <!-- Campo para Editar Quantidade -->
                            <td>
                                <input type="number" name="alimentos[{{ $alimento->pivot->id }}][quantidade]" value="{{ old('alimentos.' . $alimento->pivot->id . '.quantidade', $alimento->pivot->quantidade) }}" class="form-control" step="0.01" min="0.01">
                            </td>

                            <!-- Valor Total (calculado automaticamente) -->
                            <td>
                                R$ {{ number_format($alimento->pivot->quantidade * $alimento->pivot->valor_unitario, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3 w-100">Salvar Alterações</button>
        </form>
    </div>
</div>
@endsection
