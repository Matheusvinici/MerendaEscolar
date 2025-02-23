@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Cadastrar Orçamento</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('orcamentos.store') }}" method="POST">
            @csrf

            <!-- Descrição e Dias Letivos na mesma linha -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="descricao" class="form-label fw-bold">Descrição do Orçamento</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" required placeholder="Ex: Orçamento Mensal">
                </div>
                <div class="col-md-6">
                    <label for="dias_letivos" class="form-label fw-bold">Quantidade de Dias Letivos</label>
                    <input type="number" name="dias_letivos" id="dias_letivos" class="form-control" required min="1">
                </div>
            </div>

            <!-- Data de Início e Data de Fim na mesma linha -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_inicio" class="form-label fw-bold">Data de Início</label>
                    <input type="date" name="data_inicio" id="data_inicio" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="data_fim" class="form-label fw-bold">Data de Fim</label>
                    <input type="date" name="data_fim" id="data_fim" class="form-control" required>
                </div>
            </div>

            <!-- Seleção de Alimentos -->
            <h4 class="mb-3">Selecione os alimentos:</h4>

            <div class="row">
                @foreach($alimentos as $alimento)
                <div class="col-md-6 mb-3">
                    <div class="card p-3 shadow-sm">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input alimento-checkbox" id="alimento_{{ $alimento->id }}" name="alimentos[{{ $alimento->id }}][id]" value="{{ $alimento->id }}">
                            <label class="form-check-label fw-bold" for="alimento_{{ $alimento->id }}">
                                {{ $alimento->nome }} ({{ $alimento->unidade_medida }})
                            </label>
                        </div>
                        
                        <!-- Campo para inserir o preço unitário -->
                        <input type="number" name="alimentos[{{ $alimento->id }}][preco_unitario]" class="form-control preco-unitario d-none" placeholder="Preço Unitário (R$)" step="0.01" min="0.01" disabled>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3 w-100">Salvar Orçamento</button>
        </form>
    </div>
</div>

<!-- Script para exibir o campo de preço unitário ao selecionar um alimento -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".alimento-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                const card = this.closest(".card");
                const precoUnitarioInput = card.querySelector(".preco-unitario");

                if (this.checked) {
                    precoUnitarioInput.classList.remove("d-none");
                    precoUnitarioInput.disabled = false;
                    precoUnitarioInput.required = true;
                } else {
                    precoUnitarioInput.classList.add("d-none");
                    precoUnitarioInput.disabled = true;
                    precoUnitarioInput.required = false;
                    precoUnitarioInput.value = "";
                }
            });
        });
    });
</script>
@endsection
