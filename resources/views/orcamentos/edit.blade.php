@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Orçamento</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('orcamentos.update', $orcamento) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="descricao" class="form-label fw-bold">Descrição do Orçamento</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $orcamento->descricao }}" required>
                </div>
                <div class="col-md-6">
                    <label for="dias_letivos" class="form-label fw-bold">Quantidade de Dias Letivos</label>
                    <input type="number" name="dias_letivos" id="dias_letivos" class="form-control" value="{{ $orcamento->dias_letivos }}" required min="1">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_inicio" class="form-label fw-bold">Data de Início</label>
                    <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ $orcamento->data_inicio }}" required>
                </div>
                <div class="col-md-6">
                    <label for="data_fim" class="form-label fw-bold">Data de Fim</label>
                    <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ $orcamento->data_fim }}" required>
                </div>
            </div>

            <h4 class="mb-3">Alimentos Selecionados</h4>
            <div class="row">
                @foreach($alimentos as $alimento)
                <div class="col-md-6 mb-3">
                    <div class="card p-3 shadow-sm">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input alimento-checkbox" id="alimento_{{ $alimento->id }}" name="alimentos[{{ $alimento->id }}][id]" value="{{ $alimento->id }}" 
                            @if($orcamento->alimentos->contains($alimento->id)) checked @endif>
                            <label class="form-check-label fw-bold" for="alimento_{{ $alimento->id }}">
                                {{ $alimento->nome }} ({{ $alimento->unidade_medida }})
                            </label>
                        </div>
                        <input type="number" name="alimentos[{{ $alimento->id }}][preco_unitario]" class="form-control preco-unitario @if(!$orcamento->alimentos->contains($alimento->id)) d-none @endif" 
                            value="{{ $orcamento->alimentos->contains($alimento->id) ? $orcamento->alimentos->find($alimento->id)->pivot->valor_medio : '' }}" 
                            placeholder="Preço Unitário (R$)" step="0.01" min="0.01" 
                            @if(!$orcamento->alimentos->contains($alimento->id)) disabled @endif>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success mt-3 w-100">Salvar Alterações</button>
        </form>
    </div>
</div>

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
