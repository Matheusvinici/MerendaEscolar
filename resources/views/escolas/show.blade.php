@extends('layouts.app')

@section('content')
    <h1>Escola: {{ $escola->nome }}</h1>
    <p>INEP: {{ $escola->inep }}</p>
    <p>Bairro: {{ $escola->bairro->nome }}</p>
    <a href="{{ route('escolas.index') }}" class="btn btn-secondary">Voltar</a>
@endsection