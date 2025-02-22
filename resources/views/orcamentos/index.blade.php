@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Lista de Orçamentos</h1>
        <a href="{{ route('orcamentos.create') }}" class="btn btn-primary d-flex align-items-center">
            <span class="me-2">+</span> Cadastrar Orçamento
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead style="background-color: #1D3C6A; color: white;">
            <tr>
                <th>Descrição</th>
                <th>Total Estimado (R$)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orcamentos as $orcamento)
            <tr>
                <td>{{ $orcamento->descricao }}</td>
                <td>R$ {{ number_format($orcamento->total_estimado, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('orcamentos.edit', $orcamento->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST" class="d-inline">
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
        {{ $orcamentos->links() }}
    </div>
</div>
@endsection
