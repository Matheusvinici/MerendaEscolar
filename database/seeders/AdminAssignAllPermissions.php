<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class AdminAssignAllPermissions extends Seeder
{
    public function run()
    {
        // Limpar cache de permissões
        app('cache')->forget('spatie.permission.cache');

        try {
            DB::beginTransaction();

            // Criar ou obter o papel super-admin
            $superAdminRole = Role::firstOrCreate([
                'name' => 'super-admin',
                'guard_name' => 'web',
                'poli' => 'não',
            ]);

            // Criar ou obter o usuário super-admin
            $superAdminUser = User::firstOrCreate(
                ['email' => 'superadmin@example.com'],
                [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@example.com',
                    'password' => Hash::make('password'), // Altere a senha conforme necessário
                    'email_verified_at' => now(),
                ]
            );

            // Atribuir o papel super-admin ao usuário
            $superAdminUser->assignRole($superAdminRole);

            // Criar permissão Menu-Administracao
            Permission::firstOrCreate([
                'name' => 'Menu-Administracao',
                'guard_name' => 'web',
                'prefix' => 'admin',
            ]);

            // Gerar permissões para todas as rotas
            $this->generateRoutePermissions();

            // Atribuir todas as permissões ao papel super-admin
            $superAdminRole->syncPermissions(Permission::all());

            // Criar ou obter o papel Responsável
            $responsavelRole = Role::firstOrCreate([
                'name' => 'Responsável',
                'guard_name' => 'web',
                'poli' => 'não',
            ]);

            // Criar permissões específicas para o papel Responsável
            $responsavelPermissions = ['Acessar-Pagina-Responsavel', 'Menu-Responsavel'];
            foreach ($responsavelPermissions as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'guard_name' => 'web',
                    'prefix' => 'responsavel',
                ]);
            }

            // Atribuir permissões ao papel Responsável
            $responsavelRole->syncPermissions($responsavelPermissions);

            DB::commit();

            $this->command->info('Super-admin e papel Responsável configurados com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Erro ao executar o seeder: ' . $e->getMessage());
        }
    }

    private function generateRoutePermissions()
    {
        $routes = Route::getRoutes()->getRoutes();
        $prefixesToExclude = ['sanctum', 'ignition', 'livewire'];

        foreach ($routes as $route) {
            $name = $route->getName();

            if (!$name || $this->shouldSkipRoute($name, $prefixesToExclude)) {
                continue;
            }

            Permission::firstOrCreate([
                'name' => "access.{$name}",
                'guard_name' => 'web',
                'prefix' => $this->extractPrefix($name),
            ]);
        }
    }

    private function shouldSkipRoute($routeName, $prefixesToExclude)
    {
        foreach ($prefixesToExclude as $prefix) {
            if (str_starts_with($routeName, $prefix)) {
                return true;
            }
        }
        return false;
    }

    private function extractPrefix($routeName)
    {
        $parts = explode('.', $routeName);
        return count($parts) > 1 ? $parts[0] : null;
    }
}