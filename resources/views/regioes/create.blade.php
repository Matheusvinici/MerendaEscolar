@extends('layouts.app')

@section('content')
    <h1>Criar Região</h1>
    <form action="{{ route('regioes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection