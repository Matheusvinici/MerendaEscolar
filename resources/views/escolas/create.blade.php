@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Cadastrar Nova Escola</h1>

    <form action="{{ route('escolas.store') }}" method="POST">
        @csrf

        <!-- Nome da Escola -->
        <div class="mb-3">
            <label for="nome" class="form-label text-primary">Nome da Escola</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <!-- Endereço da Escola -->
        <div class="mb-3">
            <label for="endereco" class="form-label text-primary">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>

        <!-- Contato -->
        <div class="mb-3">
            <label for="contato" class="form-label text-primary">Contato</label>
            <input type="text" class="form-control" id="contato" name="contato" required>
        </div>

        <!-- Botão de Submissão -->
        <button type="submit" class="btn btn-primary">Cadastrar Escola</button>
    </form>
</div>
@endsection
