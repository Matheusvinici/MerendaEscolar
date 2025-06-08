@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-header">
                <div class="page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <h5 class="m-0">Adicionar Permissões</h5>
                        </div>
                    </div>
                    <div class="mt-2">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <form method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                placeholder="Nome" required>

                            @if ($errors->has('name'))
                                <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar permissão</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-default">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
