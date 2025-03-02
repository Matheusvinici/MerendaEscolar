@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Documentos Enviados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>RG/CPF Representantes Legais</td>
                <td>
                    @if($validacao->rg_cpf_representantes_legais)
                        <a href="{{ asset('storage/' . $validacao->rg_cpf_representantes_legais) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Alvara</td>
                <td>
                    @if($validacao->alvara)
                        <a href="{{ asset('storage/' . $validacao->alvara) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Alvara Sanitário</td>
                <td>
                    @if($validacao->alvara_sanitario)
                        <a href="{{ asset('storage/' . $validacao->alvara_sanitario) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certidão Negativa de Débito Municipal</td>
                <td>
                    @if($validacao->certidao_negativa_deb_municipio)
                        <a href="{{ asset('storage/' . $validacao->certidao_negativa_deb_municipio) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certidão Negativa de Débito Estaduais</td>
                <td>
                    @if($validacao->certidao_negativa_deb_estaduais)
                        <a href="{{ asset('storage/' . $validacao->certidao_negativa_deb_estaduais) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certidão Concordata/Falência/Recuperação</td>
                <td>
                    @if($validacao->certidao_concordata_falencia_recuperacao)
                        <a href="{{ asset('storage/' . $validacao->certidao_concordata_falencia_recuperacao) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certidão de Débito Crédito Tributário Federal</td>
                <td>
                    @if($validacao->certidao_deb_credito_tribt_federal)
                        <a href="{{ asset('storage/' . $validacao->certidao_deb_credito_tribt_federal) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certidão Negativa Trabalhista</td>
                <td>
                    @if($validacao->certidao_negativa_trabalhista)
                        <a href="{{ asset('storage/' . $validacao->certidao_negativa_trabalhista) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>FGTS</td>
                <td>
                    @if($validacao->fgts)
                        <a href="{{ asset('storage/' . $validacao->fgts) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Cópia do Estatuto/Posse</td>
                <td>
                    @if($validacao->copia_estatuto_posse)
                        <a href="{{ asset('storage/' . $validacao->copia_estatuto_posse) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Comprovante de Endereço da Cooperativa</td>
                <td>
                    @if($validacao->comprovante_end_cooperativa)
                        <a href="{{ asset('storage/' . $validacao->comprovante_end_cooperativa) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Comprovante de Residência dos Representantes Legais</td>
                <td>
                    @if($validacao->comprovante_resd_representantes_legais)
                        <a href="{{ asset('storage/' . $validacao->comprovante_resd_representantes_legais) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Declaração do Representante sobre Controle de Atendimento</td>
                <td>
                    @if($validacao->decl_representante_controle_atendimento)
                        <a href="{{ asset('storage/' . $validacao->decl_representante_controle_atendimento) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Projeto de Venda</td>
                <td>
                    @if($validacao->projeto_venda)
                        <a href="{{ asset('storage/' . $validacao->projeto_venda) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Declaração Genérica Alimentícia de Produção</td>
                <td>
                    @if($validacao->declaracao_gen_alimenticio_producao)
                        <a href="{{ asset('storage/' . $validacao->declaracao_gen_alimenticio_producao) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certificado de Produto Orgânico</td>
                <td>
                    @if($validacao->cert_prod_organica)
                        <a href="{{ asset('storage/' . $validacao->cert_prod_organica) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Certificado de Produto Agroecológico</td>
                <td>
                    @if($validacao->cert_prod_agroecologica)
                        <a href="{{ asset('storage/' . $validacao->cert_prod_agroecologica) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
            <tr>
                <td>Regulamento Sanitário de Alimentos</td>
                <td>
                    @if($validacao->regs_sanitario_alimentos)
                        <a href="{{ asset('storage/' . $validacao->regs_sanitario_alimentos) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
