@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Chamada Pública</h2>
    <form action="{{ route('chamadas_publicas.store') }}" method="POST">
        @csrf
        
        <!-- Título, Status e Orçamento na mesma linha -->
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aberta">Aberta</option>
                        <option value="encerrada">Encerrada</option>
                        <option value="finalizada">Finalizada</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Orçamento</label>
                    <select name="orcamento_id" class="form-control" required>
                        <option value="">Selecione um Orçamento</option>
                        @foreach($orcamentos as $orcamento)
                            <option value="{{ $orcamento->id }}">
                                {{ $orcamento->descricao }} - {{ \Carbon\Carbon::parse($orcamento->data_inicio)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($orcamento->data_fim)->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Data de Abertura e Data de Fechamento na mesma linha -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Data de Abertura</label>
                    <input type="date" name="data_abertura" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Data de Fechamento</label>
                    <input type="date" name="data_fechamento" class="form-control" required>
                </div>
            </div>
        </div>

        <!-- Descrição em uma linha separada -->
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
