@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Criar Proposta</h1>

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

    <form action="{{ route('propostas.store') }}" method="POST" id="form-proposta">
        @csrf

        <!-- Seleção da Chamada Pública -->
        <div class="form-group">
            <label for="chamada_publica_id">Chamada Pública</label>
            <select name="chamada_publica_id" id="chamada_publica_id" class="form-control" required>
                <option value="">Selecione a Chamada Pública</option>
                @foreach ($chamadasPublicas as $chamada)
                    <option value="{{ $chamada->id }}">{{ $chamada->titulo }}</option>
                @endforeach
            </select>
        </div>

        <!-- Seleção da Região -->
        <div class="form-group">
            <label for="regiao_id">Região</label>
            <select name="regiao_id" id="regiao_id" class="form-control" required>
                <option value="">Selecione a Região</option>
                @foreach ($regioes as $regiao)
                    <option value="{{ $regiao->id }}">{{ $regiao->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Informativo dos Bairros por Região -->
        <div class="form-group">
            <label>Bairros por Região</label>
            <div id="bairros-info">
                @foreach ($regioes as $regiao)
                    <div class="regiao-bairros" data-regiao="{{ $regiao->id }}" style="display: none;">
                        <strong>{{ $regiao->nome }}:</strong>
                        <ul>
                            @foreach ($regiao->bairros as $bairro)
                                <li>{{ $bairro->nome }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Seleção de Alimentos e Quantidades -->
        <h3 class="mt-4">Alimentos Disponíveis</h3>
        @foreach ($alimentos as $alimento)
            <div class="form-check">
                <input type="checkbox" name="alimentos[{{ $alimento->id }}][selecionado]" value="1" class="form-check-input alimento-checkbox" id="alimento_{{ $alimento->id }}">
                <label class="form-check-label" for="alimento_{{ $alimento->id }}">
                    {{ $alimento->nome }} - Disponível: {{ $alimento->total_kg_litro }} Kg/Litro
                    <br>
                    <small class="text-muted">Valor do Kg/Litro: R$ {{ number_format($alimento->orcamentos->first()->pivot->valor_medio, 2, ',', '.') }}</small>
                </label>
                <div class="form-group quantidade-group" style="display: none;">
                    <label for="quantidade_ofertada_{{ $alimento->id }}">Quantidade a Ofertar</label>
                    <input type="number" name="alimentos[{{ $alimento->id }}][quantidade]" id="quantidade_ofertada_{{ $alimento->id }}" class="form-control" min="0" step="0.01">
                </div>
            </div>
        @endforeach

        <!-- Botão de Envio -->
        <button type="submit" class="btn btn-success mt-3">
            <i class="fas fa-save"></i> Salvar Proposta
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

    // Exibir bairros da região selecionada
    document.getElementById('regiao_id').addEventListener('change', function () {
        const regiaoId = this.value;
        const bairrosInfo = document.querySelectorAll('.regiao-bairros');

        // Esconder todos os informativos
        bairrosInfo.forEach(info => {
            info.style.display = 'none';
        });

        // Exibir o informativo da região selecionada
        if (regiaoId) {
            const infoSelecionado = document.querySelector(`.regiao-bairros[data-regiao="${regiaoId}"]`);
            if (infoSelecionado) {
                infoSelecionado.style.display = 'block';
            }
        }
    });

    // Remover campos de alimentos não selecionados antes de enviar o formulário
    document.getElementById('form-proposta').addEventListener('submit', function (e) {
        document.querySelectorAll('.alimento-checkbox').forEach((checkbox) => {
            if (!checkbox.checked) {
                const alimentoId = checkbox.id.replace('alimento_', '');
                const quantidadeInput = document.getElementById(`quantidade_ofertada_${alimentoId}`);
                if (quantidadeInput) {
                    quantidadeInput.remove(); // Remove o campo de quantidade
                }
                checkbox.remove(); // Remove o checkbox
            }
        });
    });
</script>
@endsection
@endsection