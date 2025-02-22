@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Lista de Cardápios</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('cardapios.create') }}" class="btn btn-primary mb-3">Criar Novo Cardápio</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-primary">Nome</th>
                    <th class="text-primary">Quantidade por Porção (gramas)</th>
                    <th class="text-primary">Quantidade Total (kg)</th>
                    <th class="text-primary">Dias Servido</th>
                    <th class="text-primary">Escola</th>
                    <th class="text-primary">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cardapios as $cardapio)
                    <tr>
                        <td>{{ $cardapio->nome }}</td>
                        <td>{{ $cardapio->quantidade_porcao_gr }}</td>
                        <td>{{ $cardapio->quantidade_kg }}</td>
                        <td>{{ $cardapio->dias_servido }}</td>
                        <td>{{ $cardapio->escola->nome ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('cardapios.edit', $cardapio->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('cardapios.destroy', $cardapio->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection