@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Enviar Documentos</h2>
    <form action="{{ route('validacoes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach([
                "DAP_juridico", "alvara", "alvara_sanitario", 
                "certidao_negativa_deb_municipio", "certidao_negativa_deb_estaduais", 
                "certidao_concordata_falencia_recuperacao", "certidao_deb_credito_tribt_federal", 
                "certidao_negativa_trabalhista", "fgts", "copia_estatuto_posse", 
                "comprovante_end_cooperativa", "rg_cpf_representantes_legais", 
                "comprovante_resd_representantes_legais", "decl_representante_controle_atendimento", 
                "projeto_venda", "declaracao_gen_alimenticio_producao", "cert_prod_organica", 
                "cert_prod_agroecologica", "regs_sanitario_alimentos"
            ] as $field)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <label for="{{ $field }}" class="form-label">
                                {{ ucwords(str_replace('_', ' ', $field)) }}
                            </label>
                            <input type="file" class="form-control" name="{{ $field }}" id="{{ $field }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-upload"></i> Enviar Documentos
            </button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    /* Estilos para melhorar a responsividade */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 1.25rem;
    }
    .form-label {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }
    h2 {
        font-size: 1.75rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }
    .container {
        padding: 20px;
    }
</style>
@endsection