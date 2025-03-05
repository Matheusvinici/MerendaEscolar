@extends('layouts.app')

@section('content')
    <h1>Criar Bairro</h1>
    <form action="{{ route('bairros.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="regiao_id">Região</label>
            <select name="regiao_id" id="regiao_id" class="form-control" required>
                @foreach($regioes as $regiao)
                    <option value="{{ $regiao->id }}">{{ $regiao->nome }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection