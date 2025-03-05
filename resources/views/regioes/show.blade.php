@extends('layouts.app')

@section('content')
    <h1>Região: {{ $regiao->nome }}</h1>
    <a href="{{ route('regioes.index') }}" class="btn btn-secondary">Voltar</a>
@endsection