@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Escolas Cadastradas</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($escolas as $escola)
            <tr>
                <td>{{ $escola->nome }}</td>
                <td>{{ $escola->endereco }}</td>
                <td>{{ $escola->contato }}</td>
                <td>
                    <a href="{{ route('escolas.edit', $escola->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('escolas.destroy', $escola->id) }}" method="POST" style="display:inline;">
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
@endsection
