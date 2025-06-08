<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:Menu-Administracao']);
    }

  public function index(Request $request)
    {
        $roles = Role::orderBy('name')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'name.unique' => 'Já existe um papel com esse nome',
            'permission.required' => 'Selecione ao menos uma permissão',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('success', 'Papel criado com sucesso');
    }

    public function show(Role $role)
    {
        $rolePermissions = $role->permissions;
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::orderBy('name')->get();
        $prefixes = Permission::whereNotIn('prefix', ['auth', 'geralprefix'])
            ->orWhereNull('prefix')
            ->groupBy('prefix')
            ->orderBy('prefix')
            ->pluck('prefix');

        return view('roles.edit', compact('role', 'rolePermissions', 'permissions', 'prefixes'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required|array',
            'poli' => 'required|in:sim,não',
        ], [
            'name.required' => 'O campo nome é obrigatório',
            'name.unique' => 'Já existe um papel com esse nome',
            'permission.required' => 'Selecione ao menos uma permissão',
            'poli.required' => 'O campo poli é obrigatório',
        ]);

        $role->update([
            'name' => $request->name,
            'poli' => $request->poli,
        ]);

        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('success', 'Papel atualizado com sucesso');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Papel excluído com sucesso');
    }

    public function clone(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::orderBy('name')->get();
        return view('roles.clone', compact('role', 'rolePermissions', 'permissions'));
    }

    public function listar_papeis_usuarios(Request $request)
    {
        $roles = Role::with('users')->orderBy('name')->get();
        
        if ($request->role_id) {
            $papel = Role::findOrFail($request->role_id);
            $users = $papel->users()->orderBy('name')->paginate(10);
            return view('roles.listar_papeis_usuarios', compact('papel', 'users', 'roles'));
        }

        return view('roles.listar_papeis_usuarios', compact('roles'));
    }

    public function revogarPapel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::findOrFail($request->user_id);
        $user->removeRole($request->role);

        return response()->json(['success' => true, 'message' => 'Papel revogado com sucesso']);
    }

    public function showCopyPermissionsForm()
    {
        $roles = Role::orderBy('name')->get();
        return view('roles.copy-permissions', compact('roles'));
    }

    public function copyPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_role' => 'required|exists:roles,name',
            'target_role' => 'required|exists:roles,name|different:source_role',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sourceRole = Role::findByName($request->source_role);
        $targetRole = Role::findByName($request->target_role);

        $sourcePermissions = $sourceRole->permissions->pluck('name')->toArray();
        $targetPermissions = $targetRole->permissions->pluck('name')->toArray();
        $newPermissions = array_diff($sourcePermissions, $targetPermissions);

        if (empty($newPermissions)) {
            return redirect()->back()->with('success', "Nenhuma nova permissão adicionada. O papel {$targetRole->name} já possui todas as permissões de {$sourceRole->name}.");
        }

        $targetRole->givePermissionTo($newPermissions);

        return redirect()->back()->with('success', "Permissões adicionadas de {$sourceRole->name} para {$targetRole->name} com sucesso!");
    }
}