@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Proposta</h1>

    <form action="{{ route('propostas.update', $proposta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Seleção da Chamada Pública -->
        <div class="form-group">
            <label for="chamada_publica_id">Chamada Pública</label>
            <select name="chamada_publica_id" id="chamada_publica_id" class="form-control" required>
                <option value="">Selecione a Chamada Pública</option>
                @foreach ($chamadasPublicas as $chamada)
                    <option value="{{ $chamada->id }}" {{ $proposta->chamada_publica_id == $chamada->id ? 'selected' : '' }}>
                        {{ $chamada->descricao }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Seleção de Alimentos e Quantidades -->
        <h3 class="mt-4">Alimentos Disponíveis</h3>
        @foreach ($alimentos as $alimento)
            <div class="form-check">
                <input type="checkbox" name="alimentos[{{ $alimento->id }}][selecionado]" value="1" class="form-check-input alimento-checkbox" id="alimento_{{ $alimento->id }}"
                    {{ $proposta->alimentos->contains($alimento->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="alimento_{{ $alimento->id }}">
                    {{ $alimento->nome }} - Disponível: {{ $alimento->total_kg_litro }} {{ $alimento->unidade_medida }}
                    <br>
                    <small class="text-muted">Valor do Kg/Litro: R$ {{ number_format($alimento->orcamentos->first()->pivot->valor_medio, 2, ',', '.') }}</small>
                </label>
                <div class="form-group quantidade-group" style="display: {{ $proposta->alimentos->contains($alimento->id) ? 'block' : 'none' }};">
                    <label for="quantidade_ofertada_{{ $alimento->id }}">Quantidade a Ofertar</label>
                    <input type="number" name="alimentos[{{ $alimento->id }}][quantidade]" id="quantidade_ofertada_{{ $alimento->id }}" class="form-control" min="0" step="0.01"
                        value="{{ $proposta->alimentos->contains($alimento->id) ? $proposta->alimentos->find($alimento->id)->pivot->quantidade_ofertada : '' }}">
                </div>
            </div>
        @endforeach

        <!-- Botão de Envio -->
        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save"></i> Atualizar Proposta
        </button>
    </form>
</div>

@section('scripts')
<script>
    // Mostrar/ocultar campo de quantidade ao selecionar um alimento
    document.querySelectorAll('.alimento-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', (e) => {
            const quantidadeGroup = e.target.closest('.form-check').querySelector('.quantidade-group');
            if (e.target.checked) {
                quantidadeGroup.style.display = 'block';
            } else {
                quantidadeGroup.style.display = 'none';
            }
        });
    });
</script>
@endsection
@endsection