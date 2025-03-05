@extends('layouts.app')

@section('content')
    <h1>Bairro: {{ $bairro->nome }}</h1>
    <p>Região: {{ $bairro->regiao->nome }}</p>
    <a href="{{ route('bairros.index') }}" class="btn btn-secondary">Voltar</a>
@endsection