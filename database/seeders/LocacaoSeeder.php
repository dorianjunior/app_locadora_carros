<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Carro;
use Illuminate\Database\Seeder;

class LocacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('📋 Criando locações...');

        $clientes = Cliente::all();
        $carros = Carro::all();

        if ($clientes->isEmpty()) {
            $this->command->error('   ✗ Nenhum cliente encontrado. Execute ClienteSeeder primeiro.');
            return;
        }

        if ($carros->isEmpty()) {
            $this->command->error('   ✗ Nenhum carro encontrado. Execute CarroSeeder primeiro.');
            return;
        }

        $valoresDiaria = [80.00, 100.00, 120.00, 150.00, 180.00, 200.00, 250.00, 300.00];
        $totalLocacoes = 0;

        // Locações finalizadas (15)
        for ($i = 0; $i < 15; $i++) {
            $cliente = $clientes->random();
            $carro = $carros->random();

            $dataInicio = now()->subDays(rand(60, 180));
            $diasLocacao = rand(3, 14);
            $dataFinalPrevisto = $dataInicio->copy()->addDays($diasLocacao);
            $dataFinalRealizado = $dataFinalPrevisto->copy()->addDays(rand(-1, 2));
            $kmInicial = rand(10000, 50000);
            $kmFinal = $kmInicial + rand(100, 1000);

            // Usa relacionamento do cliente para criar a locação
            $locacao = $cliente->locacoes()->create([
                'carro_id' => $carro->id,
                'data_inicio_periodo' => $dataInicio,
                'data_final_previsto_periodo' => $dataFinalPrevisto,
                'data_final_realizado_periodo' => $dataFinalRealizado,
                'valor_diaria' => $valoresDiaria[array_rand($valoresDiaria)],
                'km_inicial' => $kmInicial,
                'km_final' => $kmFinal,
            ]);

            if ($locacao) {
                $totalLocacoes++;
            }
        }

        // Locações ativas - em andamento (5)
        for ($i = 0; $i < 5; $i++) {
            $cliente = $clientes->random();
            $carro = $carros->random();

            $dataInicio = now()->subDays(rand(1, 7));
            $diasLocacao = rand(5, 10);
            $dataFinalPrevisto = $dataInicio->copy()->addDays($diasLocacao);
            $kmInicial = rand(10000, 50000);

            // Usa relacionamento do cliente para criar a locação
            $locacao = $cliente->locacoes()->create([
                'carro_id' => $carro->id,
                'data_inicio_periodo' => $dataInicio,
                'data_final_previsto_periodo' => $dataFinalPrevisto,
                'data_final_realizado_periodo' => null,
                'valor_diaria' => $valoresDiaria[array_rand($valoresDiaria)],
                'km_inicial' => $kmInicial,
                'km_final' => null,
            ]);

            if ($locacao) {
                $totalLocacoes++;
            }
        }

        $this->command->info("   ✓ {$totalLocacoes} locações criadas");
    }
}
