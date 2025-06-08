@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        <div class="card">
            <div class="card-header">
                <h5>Gerenciar Permissões</h5>
            </div>
            <div class="card-body">
                @include('layouts.partials.messages')
                <form action="{{ route('Atribuir-Permissoes') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="roles" class="form-label">Papéis</label>
                        <select name="roles[]" id="roles" class="form-select" multiple required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permissões</label>
                        <select name="permissions[]" id="permissions" class="form-select" multiple required>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        @error('permissions')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Atribuir Permissões</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Voltar</a>
                </form>

                <h2 class="mt-5">Permissões Atuais</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Papel</th>
                            <th>Permissões</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if ($role->permissions->isEmpty())
                                        Nenhuma permissão atribuída
                                    @else
                                        {{ $role->permissions->pluck('name')->implode(', ') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#roles, #permissions').select2({
                theme: 'bootstrap-5',
                placeholder: 'Selecione uma ou mais opções',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection