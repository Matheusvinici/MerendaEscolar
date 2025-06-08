@extends('layouts.app')

@section('content')
    <div class="bg-light rounded">
        <div class="card m-4">
            <div class="card-header">
                <h5>Adicionar Novo Papel</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                  

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Nome do papel" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Permissões</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="1%"><input type="checkbox" id="all_permission"></th>
                                    <th width="20%">Nome</th>
                                    <th width="1%">Guard</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!is_null($permissions) && $permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="permission[]" value="{{ $permission->name }}" class="permission">
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">Nenhuma permissão disponível ou erro ao carregar.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @error('permission')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            $(document).ready(function () {
                $('#all_permission').on('click', function () {
                    $('.permission').prop('checked', $(this).is(':checked'));
                });
            });
        </script>
    @endsection
@endsection