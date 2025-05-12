<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário admin padrão
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@merenda.com',
            'password' => bcrypt('senha123') // Troque por uma senha segura
        ]);

        // Chamar as outras seeders
        $this->call([
            EscolasTableSeeder::class,
            AlunoSeeder::class,
            UserSeeder::class,

            AlimentoSeeder::class,
            CardapioSeeder::class,
        ]);
    }
}