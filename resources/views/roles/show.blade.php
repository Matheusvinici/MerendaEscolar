@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        @include('layouts.partials.messages')
        <div class="card m-4">
            <div class="card-header">
                <h5>Papel: {{ ucwords(str_replace('-', ' ', $role->name)) }}</h5>
                <div>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-info"><i class="bi bi-list"></i></a>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                    @can('Clonar-Papel')
                        <a href="{{ route('Clonar-Papel', $role->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-files"></i></a>
                    @endcan
                    @can('roles.destroy')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este papel?')"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <h6>Permissões</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Guard</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolePermissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection