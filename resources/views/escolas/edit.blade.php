@extends('layouts.app')

@section('content')
    <h1>Editar Escola</h1>
    <form action="{{ route('escolas.update', $escola->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ $escola->nome }}" required>
        </div>
        <div class="form-group">
            <label for="inep">INEP</label>
            <input type="text" name="inep" id="inep" class="form-control" value="{{ $escola->inep }}" required>
        </div>
        <div class="form-group">
            <label for="bairro_id">Bairro</label>
            <select name="bairro_id" id="bairro_id" class="form-control" required>
                @foreach($bairros as $bairro)
                    <option value="{{ $bairro->id }}" {{ $escola->bairro_id == $bairro->id ? 'selected' : '' }}>
                        {{ $bairro->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>
@endsection