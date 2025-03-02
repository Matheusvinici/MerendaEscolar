@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Chamadas Públicas</h2>
        <a href="{{ route('chamadas_publicas.create') }}" class="btn btn-dark">Registrar Chamada Pública</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Título</th>
                <th>Data de Abertura</th>
                <th>Data de Fechamento</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamadasPublicas as $chamadaPublica)
            <tr>
                <td>{{ $chamadaPublica->titulo }}</td>
                <td>{{ \Carbon\Carbon::parse($chamadaPublica->data_abertura)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($chamadaPublica->data_fechamento)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($chamadaPublica->status) }}</td>
                <td>
                    <a href="{{ route('chamadas_publicas.show', $chamadaPublica->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('chamadas_publicas.edit', $chamadaPublica->id) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('chamadas_publicas.destroy', $chamadaPublica->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
