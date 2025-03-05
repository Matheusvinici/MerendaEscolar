<!-- resources/views/avaliacoes/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Propostas</h1>

 

    <!-- Resumo de Propostas -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Resumo de Propostas</h5>
            <p><strong>Total Pendentes:</strong> {{ $propostasPendentes->total() }}</p>
            <p><strong>Total Aprovadas:</strong> {{ $propostasAprovadas->total() }}</p>
            <p><strong>Total Reprovadas:</strong> {{ $propostasReprovadas->total() }}</p>
            <div class="mt-3">
                <a href="{{ route('avaliacoes.export.pdf', ['status' => 'pendente']) }}" class="btn btn-danger">Gerar PDF Pendentes</a>
                <a href="{{ route('avaliacoes.export.pdf', ['status' => 'aprovada']) }}" class="btn btn-success">Gerar PDF Aprovadas</a>
                <a href="{{ route('avaliacoes.export.pdf', ['status' => 'reprovada']) }}" class="btn btn-warning">Gerar PDF Reprovadas</a>
            </div>
        </div>
    </div>

    <!-- Abas para Propostas Pendentes, Aprovadas e Reprovadas -->
    <ul class="nav nav-tabs" id="propostasTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pendentes-tab" data-toggle="tab" href="#pendentes" role="tab" aria-controls="pendentes" aria-selected="true">Pendentes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="aprovadas-tab" data-toggle="tab" href="#aprovadas" role="tab" aria-controls="aprovadas" aria-selected="false">Aprovadas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="reprovadas-tab" data-toggle="tab" href="#reprovadas" role="tab" aria-controls="reprovadas" aria-selected="false">Reprovadas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="porcentagem-tab" data-toggle="tab" href="#porcentagem" role="tab" aria-controls="porcentagem" aria-selected="false">Porcentagem de Aprovação por Região</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="resumo-tab" data-toggle="tab" href="#resumo" role="tab" aria-controls="resumo" aria-selected="false">Resumo de Alimentos</a>
        </li>
    </ul>

    <!-- Conteúdo das Abas -->
    <div class="tab-content" id="propostasTabContent">
        <!-- Aba Pendentes -->
        <div class="tab-pane fade show active" id="pendentes" role="tabpanel" aria-labelledby="pendentes-tab">
            @include('avaliacoes.partials.propostas', ['propostas' => $propostasPendentes, 'status' => 'pendente'])
        </div>

        <!-- Aba Aprovadas -->
        <div class="tab-pane fade" id="aprovadas" role="tabpanel" aria-labelledby="aprovadas-tab">
            @include('avaliacoes.partials.propostas', ['propostas' => $propostasAprovadas, 'status' => 'aprovada'])
        </div>

        <!-- Aba Reprovadas -->
        <div class="tab-pane fade" id="reprovadas" role="tabpanel" aria-labelledby="reprovadas-tab">
            @include('avaliacoes.partials.propostas', ['propostas' => $propostasReprovadas, 'status' => 'reprovada'])
        </div>

        <!-- Aba Porcentagem de Aprovação por Região -->
        <div class="tab-pane fade" id="porcentagem" role="tabpanel" aria-labelledby="porcentagem-tab">
            @include('avaliacoes.partials.porcentagem-aprovacao-regiao', [
                'porcentagemAprovadaPorRegiao' => $porcentagemAprovadaPorRegiao,
                'regioes' => $regioes
            ])
        </div>

        <!-- Aba Resumo de Alimentos -->
        <div class="tab-pane fade" id="resumo" role="tabpanel" aria-labelledby="resumo-tab">
            @include('avaliacoes.partials.resumo-alimentos', [
                'alimentosTotais' => $alimentosTotais
            ])
        </div>
    </div>
</div>
<script>
    // Função para ativar a aba com base no hash da URL
    function activateTabFromHash() {
        const hash = window.location.hash;
        if (hash) {
            const tabLink = document.querySelector(`a[href="${hash}"]`);
            if (tabLink) {
                new bootstrap.Tab(tabLink).show();
            }
        }
    }

    // Ativar a aba ao carregar a página
    document.addEventListener('DOMContentLoaded', activateTabFromHash);

    // Ativar a aba ao alterar o hash da URL
    window.addEventListener('hashchange', activateTabFromHash);
</script>
@endsection