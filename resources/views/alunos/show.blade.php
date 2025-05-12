@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">Detalhes do Registro</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('alunos.index') }}">Alunos</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('alunos.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Informações da Escola</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Escola</label>
                    <p class="fw-medium">{{ $aluno->escola->nome }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Ano Letivo</label>
                    <p class="fw-medium">{{ $aluno->ano_letivo }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Quantitativo de Alunos</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Creche Parcial</label>
                    <p class="fw-medium">{{ $aluno->creche_parcial }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Creche Integral</label>
                    <p class="fw-medium">{{ $aluno->creche_integral }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Pré-escolar Parcial</label>
                    <p class="fw-medium">{{ $aluno->pre_parcial }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Pré-escolar Integral</label>
                    <p class="fw-medium">{{ $aluno->pre_integral }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Fundamental Parcial</label>
                    <p class="fw-medium">{{ $aluno->fundamental_parcial }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Fundamental Integral</label>
                    <p class="fw-medium">{{ $aluno->fundamental_integral }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">EJA</label>
                    <p class="fw-medium">{{ $aluno->eja }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Total Geral</label>
                    <p class="fw-bold text-primary fs-5">
                        {{ $aluno->creche_parcial + $aluno->creche_integral + $aluno->pre_parcial + $aluno->pre_integral + $aluno->fundamental_parcial + $aluno->fundamental_integral + $aluno->eja }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection