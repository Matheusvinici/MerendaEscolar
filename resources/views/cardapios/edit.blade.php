@extends('layouts.app')

@section('content')
<div class="container bg-light p-4 rounded">
    <h1 class="text-primary mb-4">Editar Cardápio</h1>

    <form action="{{ route('cardapios.update', $cardapio->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label text-primary">Nome do Cardápio</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $cardapio->nome }}" required>
        </div>

        <div class="mb-3">
            <label for="quantidade_porcao_gr" class="form-label text-primary">Quantidade por Porção (gramas)</label>
            <input type="number" step="0.01" class="form-control" id="quantidade_porcao_gr" name="quantidade_porcao_gr" value="{{ $cardapio->quantidade_porcao_gr }}">
        </div>

        <div class="mb-3">
            <label for="quantidade_kg" class="form-label text-primary">Quantidade Total (kg)</label>
            <input type="number" step="0.01" class="form-control" id="quantidade_kg" name="quantidade_kg" value="{{ $cardapio->quantidade_kg }}">
        </div>

        <div class="mb-3">
            <label for="dias_servido" class="form-label text-primary">Dias Servido</label>
            <input type="number" step="0.01" class="form-control" id="dias_servido" name="dias_servido" value="{{ $cardapio->dias_servido }}">
        </div>

        <div class="mb-3">
            <label for="escola_id" class="form-label text-primary">Escola</label>
            <select class="form-control" id="escola_id" name="escola_id">
                <option value="">Selecione uma escola</option>
                @foreach($escolas as $escola)
                    <option value="{{ $escola->id }}" {{ $cardapio->escola_id == $escola->id ? 'selected' : '' }}>{{ $escola->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="alimento_id" class="form-label text-primary">Alimento</label>
            <select class="form-control" id="alimento_id" name="alimento_id">
                <option value="">Selecione um alimento</option>
                @foreach($alimentos as $alimento)
                    <option value="{{ $alimento->id }}" {{ $cardapio->alimento_id == $alimento->id ? 'selected' : '' }}>{{ $alimento->nome }}</option>
                @endforeach
            </select>
        </div>

      

        <button type="submit" class="btn btn-primary">Atualizar Cardápio</button>
    </form>
</div>
@endsection