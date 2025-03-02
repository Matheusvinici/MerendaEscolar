
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Documentos Enviados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
               
                <th>RG/CPF Representantes Legais</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($validacoes as $validacao)
            <tr>
            <td>
                    @if($validacao->rg_cpf_representantes_legais)
                        <a href="{{ asset('storage/' . $validacao->rg_cpf_representantes_legais) }}" target="_blank">Ver Documento</a>
                    @else
                        Não enviado
                    @endif
                </td>
                <td>
                <a href="{{ route('validacoes.show', $validacao->id) }}" class="btn btn-info">Ver todos os Documentos</a>
                <a href="#" class="btn btn-primary">Editar</a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection