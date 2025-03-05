@extends('layouts.app')

@section('content')
    <h1>Editar Bairro</h1>
    <form action="{{ route('bairros.update', $bairro->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ $bairro->nome }}" required>
        </div>
        <div class="form-group">
            <label for="regiao_id">Região</label>
            <select name="regiao_id" id="regiao_id" class="form-control" required>
                @foreach($regioes as $regiao)
                    <option value="{{ $regiao->id }}" {{ $bairro->regiao_id == $regiao->id ? 'selected' : '' }}>
                        {{ $regiao->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
@endsection