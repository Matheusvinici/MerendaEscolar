@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Lista de Alimentos</h1>
        <a href="{{ route('alimentos.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="me-2">+</span> Novo Alimento
        </a>
    </div>

    <form action="{{ route('alimentos.index') }}" method="GET" class="mb-4">
        <div class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Buscar por Alimento" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Unidade de Medida</th>
                <th>Valor Médio (R$)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alimentos as $alimento)
            <tr>
                <td>{{ $alimento->nome }}</td>
                <td>{{ $alimento->unidade_medida }}</td>
                <td>R$ {{ number_format($alimento->valor_medio, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('alimentos.show', $alimento->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('alimentos.destroy', $alimento->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $alimentos->links() }}
    </div>
</div>
@endsection
