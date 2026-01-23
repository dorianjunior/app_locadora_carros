<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🏎️  Criando modelos...');

        $modelosPorMarca = [
            'Fiat' => [
                ['nome' => 'Uno', 'imagem' => 'imagens/uno.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Palio', 'imagem' => 'imagens/palio.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Argo', 'imagem' => 'imagens/argo.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Toro', 'imagem' => 'imagens/toro.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Volkswagen' => [
                ['nome' => 'Gol', 'imagem' => 'imagens/gol.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Polo', 'imagem' => 'imagens/polo.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'T-Cross', 'imagem' => 'imagens/tcross.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Virtus', 'imagem' => 'imagens/virtus.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Chevrolet' => [
                ['nome' => 'Onix', 'imagem' => 'imagens/onix.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Tracker', 'imagem' => 'imagens/tracker.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'S10', 'imagem' => 'imagens/s10.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Ford' => [
                ['nome' => 'Ka', 'imagem' => 'imagens/ka.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => false],
                ['nome' => 'EcoSport', 'imagem' => 'imagens/ecosport.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Ranger', 'imagem' => 'imagens/ranger.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Renault' => [
                ['nome' => 'Kwid', 'imagem' => 'imagens/kwid.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => false],
                ['nome' => 'Sandero', 'imagem' => 'imagens/sandero.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Duster', 'imagem' => 'imagens/duster.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Toyota' => [
                ['nome' => 'Corolla', 'imagem' => 'imagens/corolla.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Hilux', 'imagem' => 'imagens/hilux.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Honda' => [
                ['nome' => 'Civic', 'imagem' => 'imagens/civic.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'HR-V', 'imagem' => 'imagens/hrv.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Hyundai' => [
                ['nome' => 'HB20', 'imagem' => 'imagens/hb20.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Creta', 'imagem' => 'imagens/creta.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Nissan' => [
                ['nome' => 'Kicks', 'imagem' => 'imagens/kicks.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Versa', 'imagem' => 'imagens/versa.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
            'Jeep' => [
                ['nome' => 'Renegade', 'imagem' => 'imagens/renegade.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
                ['nome' => 'Compass', 'imagem' => 'imagens/compass.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ],
        ];

        $totalModelos = 0;

        foreach ($modelosPorMarca as $nomeMarca => $modelos) {
            $marca = Marca::where('nome', $nomeMarca)->first();

            if (!$marca) {
                $this->command->warn("   ⚠ Marca '{$nomeMarca}' não encontrada. Pulando...");
                continue;
            }

            foreach ($modelos as $modeloData) {
                // Usa relacionamento para criar o modelo
                $marca->modelos()->firstOrCreate(
                    ['nome' => $modeloData['nome']],
                    $modeloData
                );
                $totalModelos++;
            }
        }

        $this->command->info("   ✓ {$totalModelos} modelos criados");
    }
}
