@extends('layouts.app')

@section('content')
    <h1>Editar Região</h1>
    <form action="{{ route('regioes.update', $regiao->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ $regiao->nome }}" required>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
@endsection