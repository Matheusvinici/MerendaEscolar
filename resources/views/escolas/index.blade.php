@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Escolas</h2>
        <a href="{{ route('escolas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Escola
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nome</th>
                    <th>Código INEP</th>
                    <th>Cadastros</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($escolas as $escola)
                <tr>
                    <td>{{ $escola->nome }}</td>
                    <td>{{ $escola->codigo_inep }}</td>
                    <td>{{ $escola->alunos->count() }} ano(s)</td>
                    <td>
                        <a href="{{ route('escolas.show', $escola->id) }}" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('escolas.edit', $escola->id) }}" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('escolas.destroy', $escola->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta escola?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhuma escola cadastrada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection