@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        @include('layouts.partials.messages')
        <div class="card m-4">
            <div class="card-header">
                <h5>Adicionar Permissões de Papel</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('Copy-Permissions') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="source_role" class="form-label">Papel de Origem</label>
                        <select name="source_role" id="source_role" class="form-select" required>
                            <option value="">Selecione um papel</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('source_role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('source_role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="target_role" class="form-label">Papel de Destino</label>
                        <select name="target_role" id="target_role" class="form-select" required>
                            <option value="">Selecione um papel</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('target_role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('target_role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Adicionar Permissões</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            $(document).ready(function () {
                $('.form-select').select2({
                    placeholder: "Selecione um papel",
                    allowClear: true,
                    width: '100%',
                });
            });
        </script>
    @endsection
@endsection