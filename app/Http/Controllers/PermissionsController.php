<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:Menu-Administracao']);
    }

    public function index()
    {   
        $permissions = Permission::orderBy('name')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create() 
    {   
        return view('permissions.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|unique:permissions,name',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.*.unique' => 'Uma das permissões já existe.',
        ]);

        foreach ($request->name as $name) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permissões criadas com sucesso.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$permission->id,
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'Já existe uma permissão com esse nome.',
        ]);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success', 'Permissão atualizada com sucesso.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')
            ->with('success', 'Permissão excluída com sucesso.');
    }

    public function gerenciar_permissoes()
    {
        $roles = Role::all();
        $permissions = Permission::orderBy('name')->get();
        return view('permissions.gerenciar_permissoes', compact('roles', 'permissions'));
    }

    public function atribuir(Request $request)
    {
        $request->validate([
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'roles.required' => 'Selecione pelo menos um papel.',
            'permissions.required' => 'Selecione pelo menos uma permissão.',
        ]);

        try {
            foreach ($request->roles as $roleId) {
                $role = Role::findOrFail($roleId);
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            }
            return redirect()->route('Gerenciar-Permissoes')
                ->with('success', 'Permissões atribuídas com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atribuir permissões: ' . $e->getMessage());
            return redirect()->route('Gerenciar-Permissoes')
                ->with('error', 'Erro ao atribuir permissões.');
        }
    }
}