@extends('layouts.app')

@section('content')
  
    <div class="bg-light rounded">
        
        <div class="card m-4">
            <div class="card-header">
                <h5>Papéis</h5>
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Adicionar</a>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Poli</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords(str_replace('-', ' ', $role->name)) }}</td>
                                <td>{{ $role->poli }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">Ver</a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">Editar</a>
                                    @can('Clonar-Papel')
                                        <a class="btn btn-secondary btn-sm" href="{{ route('Clonar-Papel', $role->id) }}">Clonar</a>
                                    @endcan
                                    @can('roles.destroy')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este papel?')">Excluir</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex mt-3">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection