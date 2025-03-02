@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Cadastrar Documentação de Validação</h2>

    <form action="{{ route('validacoes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            @foreach ([
                'DAP_juridico', 'alvara', 'alvara_sanitario', 'certidao_negativa_deb_municipio', 
                'certidao_negativa_deb_estaduais', 'certidao_concordata_falencia_recuperacao', 
                'certidao_deb_credito_tribt_federal', 'certidao_negativa_trabalhista', 'fgts', 'copia_estatuto_posse'
            ] as $field)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card p-3 shadow-sm">
                        <label for="{{ $field }}" class="form-label fw-bold">{{ str_replace('_', ' ', ucfirst($field)) }}</label>
                        <input type="file" name="{{ $field }}" id="{{ $field }}" class="form-control">
                        <button type="button" class="btn btn-primary mt-2 w-100" onclick="playAudio('teste1.mp3')">🎵 Ouvir Dica</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            @foreach ([
                'comprovante_end_cooperativa', 'rg_cpf_representantes_legais', 'comprovante_resd_representantes_legais', 
                'decl_representante_controle_atendimento', 'projeto_venda', 'declaracao_gen_alimenticio_producao', 
                'cert_prod_organica', 'cert_prod_agroecologica', 'regs_sanitario_alimentos'
            ] as $field)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card p-3 shadow-sm">
                        <label for="{{ $field }}" class="form-label fw-bold">{{ str_replace('_', ' ', ucfirst($field)) }}</label>
                        <input type="file" name="{{ $field }}" id="{{ $field }}" class="form-control">
                        <button type="button" class="btn btn-success mt-2 w-100" onclick="playAudio('teste2.mp3')">🎵 Ouvir Dica</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4">Cadastrar</button>
    </form>

    <!-- Player de Áudio Invisível -->
    <audio id="audioPlayer" controls style="display:none;">
        <source id="audioSource" src="" type="audio/mpeg">
        Seu navegador não suporta áudio.
    </audio>
</div>

<script>
    function playAudio(audioFile) {
        var audioPlayer = document.getElementById('audioPlayer');
        var audioSource = document.getElementById('audioSource');
        audioSource.src = "/audios/" + audioFile;
        audioPlayer.load();
        audioPlayer.play();
    }
</script>

<style>
    .card {
        border-radius: 10px;
        border: 1px solid #ddd;
        transition: 0.3s;
    }

    .card:hover {
        transform: scale(1.03);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn {
        font-weight: bold;
        border-radius: 8px;
    }
</style>
@endsection
