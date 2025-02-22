@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Criar Orçamento</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('orcamentos.store') }}" method="POST">
            @csrf

            <!-- Campo de Descrição -->
            <div class="mb-4">
                <label for="descricao" class="form-label fw-bold">Descrição do Orçamento</label>
                <input type="text" name="descricao" class="form-control" required placeholder="Ex: Orçamento Mensal">
            </div>

            <!-- Seleção de Alimentos -->
            <h4 class="mb-3">Selecione os alimentos:</h4>

            <div class="row">
                @foreach($alimentos as $alimento)
                <div class="col-md-6 mb-3">
                    <div class="card p-3 shadow-sm">
                        <div class="form-check">
                            <!-- Checkbox para selecionar o alimento -->
                            <input type="checkbox" class="form-check-input alimento-checkbox" id="alimento_{{ $alimento->id }}" value="{{ $alimento->id }}">
                            <label class="form-check-label fw-bold" for="alimento_{{ $alimento->id }}">
                                {{ $alimento->nome }} ({{ $alimento->unidade_medida }})  
                            </label>
                            <p class="text-muted mb-2">Preço médio: <strong>R$ {{ number_format($alimento->valor_medio, 2, ',', '.') }}</strong></p>

                            <!-- Campos ocultos para alimentos selecionados -->
                            <input type="hidden" name="alimentos[{{ $alimento->id }}][id]" class="alimento-id" disabled>
                            <input type="number" name="alimentos[{{ $alimento->id }}][quantidade]" class="form-control quantidade-input d-none" placeholder="Quantidade" step="0.01" min="0.01" disabled>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3 w-100">Salvar Orçamento</button>
        </form>
    </div>
</div>

<!-- Script para exibir os campos de quantidade apenas quando necessário -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".alimento-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                const card = this.closest(".card");
                const quantidadeInput = card.querySelector(".quantidade-input");
                const alimentoIdInput = card.querySelector(".alimento-id");

                if (this.checked) {
                    quantidadeInput.classList.remove("d-none");
                    quantidadeInput.disabled = false;
                    quantidadeInput.required = true;

                    alimentoIdInput.value = this.value;
                    alimentoIdInput.disabled = false;
                } else {
                    quantidadeInput.classList.add("d-none");
                    quantidadeInput.disabled = true;
                    quantidadeInput.required = false;
                    quantidadeInput.value = "";

                    alimentoIdInput.value = "";
                    alimentoIdInput.disabled = true;
                }
            });
        });
    });
</script>
@endsection
