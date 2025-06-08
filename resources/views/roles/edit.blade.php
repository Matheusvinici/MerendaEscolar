@extends('layouts.app')

@section('content')
    @can('Menu-Administracao')
        @include('layouts.partials.navbar-adm')
    @endcan

    <div class="bg-light rounded">
        @include('layouts.partials.messages')
        <div class="card m-4">
            <div class="card-header">
                <h5>Editar Papel: {{ ucwords(str_replace('-', ' ', $role->name)) }}</h5>
                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-info"><i class="bi bi-list"></i></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="poli" class="form-label">Poli-Institucional (Acesso de nível de rede de ensino)?</label>
                                <select name="poli" id="poli" class="form-control" required>
                                    @foreach (config('enums.nao_sim') as $key => $value)
                                        <option value="{{ $key }}" {{ $role->poli == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('poli')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input value="{{ $role->name }}" type="text" class="form-control" name="name" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @foreach ($prefixes as $prefix)
                                <div id="{{ Str::upper($prefix) }}">
                                    <label class="form-label">{{ Str::upper($prefix) }}</label>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" id="all_permission_{{ $prefix }}"></th>
                                                <th width="20%">Nome</th>
                                                <th width="1%">Guard</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                @if ($permission->prefix == $prefix)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="permission[]" value="{{ $permission->name }}"
                                                                class="permission_{{ $prefix }}"
                                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>{{ $permission->name }}</td>
                                                        <td>{{ $permission->guard_name }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @section('javascript')
                                        <script>
                                            $(document).ready(function () {
                                                $('#all_permission_{{ $prefix }}').on('click', function () {
                                                    $('.permission_{{ $prefix }}').prop('checked', $(this).is(':checked'));
                                                });
                                            });
                                        </script>
                                    @endsection
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Voltar</a>
                        </form>
                    </div>
                    <div class="col-3" style="position: fixed; top: 100px; right: 30px; overflow: auto; max-height: 70vh; z-index: 50">
                        @foreach ($prefixes as $prefix)
                            <a href="#{{ Str::upper($prefix) }}" class="d-block mb-2">{{ Str::upper($prefix) }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection