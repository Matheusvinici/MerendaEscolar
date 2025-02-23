@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Alimentos</h2>
        <a href="{{ route('alimentos.create') }}" class="btn btn-dark">Registrar Alimento</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Alimento</th>
                <th>Unidade de Medida</th>
                <th>Total (kg/L)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alimentos as $alimento)
            <tr>
                <td>{{ $alimento->nome }}</td>
                <td>{{ $alimento->unidade_medida }}</td>
                <td>{{ $alimento->total_kg_litro }}</td> <!-- Exibe o valor calculado no controlador -->
                <td>
                    <a href="{{ route('alimentos.show', $alimento->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('alimentos.destroy', $alimento->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
