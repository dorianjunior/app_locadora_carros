<?php

namespace Database\Seeders;

use App\Models\Modelo;
use Illuminate\Database\Seeder;

class CarroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🚙 Criando frota de carros...');

        $placas = [
            'ABC-1234', 'DEF-5678', 'GHI-9012', 'JKL-3456', 'MNO-7890',
            'PQR-1122', 'STU-3344', 'VWX-5566', 'YZA-7788', 'BCD-9900',
            'EFG-1212', 'HIJ-3434', 'KLM-5656', 'NOP-7878', 'QRS-9090',
            'TUV-2121', 'WXY-4343', 'ZAB-6565', 'CDE-8787', 'FGH-0909',
            'IJK-1357', 'LMN-2468', 'OPQ-1593', 'RST-2604', 'UVW-3715',
            'XYZ-4826', 'ABC-5937', 'DEF-6048', 'GHI-7159', 'JKL-8260',
        ];

        $kms = [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000];
        $modelos = Modelo::all();

        if ($modelos->isEmpty()) {
            $this->command->error('   ✗ Nenhum modelo encontrado. Execute ModeloSeeder primeiro.');
            return;
        }

        $totalCarros = 0;

        foreach ($placas as $index => $placa) {
            $modelo = $modelos->random();

            // Usa relacionamento para criar o carro
            $modelo->carros()->firstOrCreate(
                ['placa' => $placa],
                [
                    'disponivel' => $index % 3 !== 0, // 66% disponíveis
                    'km' => $kms[array_rand($kms)]
                ]
            );
            $totalCarros++;
        }

        $this->command->info("   ✓ {$totalCarros} carros criados");
    }
}
