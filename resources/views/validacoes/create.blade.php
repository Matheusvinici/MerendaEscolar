@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Enviar Documentos</h2>
    <form action="{{ route('validacoes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach(["DAP_juridico", "alvara", "alvara_sanitario", "certidao_negativa_deb_municipio", "certidao_negativa_deb_estaduais", "certidao_concordata_falencia_recuperacao", "certidao_deb_credito_tribt_federal", "certidao_negativa_trabalhista", "fgts", "copia_estatuto_posse", "comprovante_end_cooperativa", "rg_cpf_representantes_legais", "comprovante_resd_representantes_legais", "decl_representante_controle_atendimento", "projeto_venda", "declaracao_gen_alimenticio_producao", "cert_prod_organica", "cert_prod_agroecologica", "regs_sanitario_alimentos"] as $field)
        <div class="mb-3">
            <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
            <input type="file" class="form-control" name="{{ $field }}">
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection