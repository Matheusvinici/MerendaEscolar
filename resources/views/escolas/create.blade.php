@extends('layouts.app')

@section('content')
    <h1>Criar Escola</h1>
    <!-- escolas.create.blade.php e escolas.edit.blade.php -->
<form method="POST" action="{{ isset($escola) ? route('escolas.update', $escola->id) : route('escolas.store') }}">
    @csrf
    @if(isset($escola))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ isset($escola) ? $escola->nome : '' }}" required>
    </div>

    <div class="form-group">
        <label for="inep">INEP</label>
        <input type="text" name="inep" id="inep" class="form-control" value="{{ isset($escola) ? $escola->inep : '' }}">
    </div>

    <div class="form-group">
        <label for="bairro_id">Bairro</label>
        <select name="bairro_id" id="bairro_id" class="form-control" required>
            @foreach($bairros as $bairro)
                <option value="{{ $bairro->id }}" {{ isset($escola) && $escola->bairro_id == $bairro->id ? 'selected' : '' }}>{{ $bairro->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="pre_escola_alunos">Alunos Pré-Escola</label>
        <input type="number" name="pre_escola_alunos" id="pre_escola_alunos" class="form-control" value="{{ isset($escola) ? $escola->pre_escola_alunos : '' }}">
    </div>

    <div class="form-group">
        <label for="fundamental_alunos">Alunos Fundamental</label>
        <input type="number" name="fundamental_alunos" id="fundamental_alunos" class="form-control" value="{{ isset($escola) ? $escola->fundamental_alunos : '' }}">
    </div>

    <div class="form-group">
        <label for="eja_alunos">Alunos EJA</label>
        <input type="number" name="eja_alunos" id="eja_alunos" class="form-control" value="{{ isset($escola) ? $escola->eja_alunos : '' }}">
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($escola) ? 'Atualizar' : 'Cadastrar' }}</button>
</form>
@endsection