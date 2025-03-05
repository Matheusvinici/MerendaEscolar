@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Avaliar Proposta #{{ $proposta->id }}</h1>

    <!-- Exibir mensagens de erro -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Exibir mensagens de sucesso -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('avaliacoes.store', $proposta) }}" method="POST">
    @csrf
    <input type="hidden" name="proposta_id" value="{{ $proposta->id }}">

    <!-- Outros campos do formulário -->
    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control" required>
            <option value="aprovada">Aprovada</option>
            <option value="reprovada">Reprovada</option>
        </select>
    </div>

    <div class="form-group">
        <label for="comentario">Comentário:</label>
        <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
    </div>

    <!-- Alimentos da Proposta -->
    @foreach ($alimentos as $alimento)
        <div class="form-group">
            <label>{{ $alimento->nome }}</label>
            <div class="row">
                <div class="col-md-6">
                    <label>Quantidade Ofertada (kg/litro):</label>
                    <input type="number" class="form-control" value="{{ $alimento->pivot->quantidade_ofertada }}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Quantidade Aprovada (kg/litro):</label>
                    <input type="number" name="alimentos[{{ $alimento->id }}][quantidade_aprovada]" class="form-control" value="{{ $alimento->pivot->quantidade_ofertada }}" min="0" step="0.01">
                </div>
            </div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary mt-3">Salvar Avaliação</button>
</form>
</div>
@endsection