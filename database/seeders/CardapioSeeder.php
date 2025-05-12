<?php

namespace Database\Seeders;

use App\Models\Cardapio;
use App\Models\Escola;
use App\Models\Segmento;
use App\Models\Alimento;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CardapioSeeder extends Seeder
{
    public function run()
    {
        // Obter alguns registros existentes
        $escolas = Escola::take(3)->get();
        $segmentos = Segmento::all();
        $alimentos = Alimento::where('ativo', true)->get();

        // Verificar se existem escolas e segmentos cadastrados
        if ($escolas->isEmpty() || $segmentos->isEmpty()) {
            $this->command->warn('Por favor, execute os seeders de Escola e Segmento primeiro!');
            return;
        }

        // Cardápio padrão para cada segmento
        foreach ($segmentos as $segmento) {
            $cardapio = Cardapio::create([
                'nome' => 'Cardápio Padrão ' . $segmento->nome,
                'escola_id' => $escolas->random()->id,
                'segmento_id' => $segmento->id,
                'data_inicio' => Carbon::now()->startOfMonth(),
                'data_fim' => Carbon::now()->endOfMonth(),
                'observacoes' => 'Cardápio padrão para ' . $segmento->nome,
                'ativo' => true,
                'padrao' => true
            ]);

            // Vincular 3-5 alimentos ao cardápio se existirem
            if ($alimentos->isNotEmpty()) {
                $alimentosAleatorios = $alimentos->random(min(5, $alimentos->count()));
                $cardapio->alimentos()->attach($alimentosAleatorios);
            }
        }

        // Cardápios adicionais (não padrão)
        for ($i = 0; $i < 5; $i++) {
            $startDate = Carbon::now()->addDays(rand(0, 30));
            $endDate = $startDate->copy()->addDays(rand(7, 14));

            $cardapio = Cardapio::create([
                'nome' => 'Cardápio Especial ' . ($i + 1),
                'escola_id' => $escolas->random()->id,
                'segmento_id' => $segmentos->random()->id,
                'data_inicio' => $startDate,
                'data_fim' => $endDate,
                'observacoes' => 'Cardápio especial com variações sazonais',
                'ativo' => rand(0, 1),
                'padrao' => false
            ]);

            // Vincular 3-5 alimentos ao cardápio se existirem
            if ($alimentos->isNotEmpty()) {
                $alimentosAleatorios = $alimentos->random(min(5, $alimentos->count()));
                $cardapio->alimentos()->attach($alimentosAleatorios);
            }
        }

        $this->command->info('Cardápios gerados com sucesso!');
    }
}