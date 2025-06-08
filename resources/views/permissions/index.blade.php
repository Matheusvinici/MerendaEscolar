@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        <div class="card">
            <div class="card-header">
                <div class="page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <h5 class="m-0">Permissões</h5>
                        </div>
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">Adicionar</a>
                    </div>
                    <div class="mt-2">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" colspan="1" width="1%"></th>
                            <th scope="col" width="15%">Nome</th>
                            <th scope="col">Guard</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td><a href="{{ route('permissions.edit', $permission->id) }}"
                                        class="btn btn-info btn-sm">Editar</a></td>
                                <!-- <td></td> -->
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
