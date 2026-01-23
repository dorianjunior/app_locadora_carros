<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🚗 Criando marcas...');

        $marcas = [
            ['nome' => 'Fiat', 'imagem' => 'imagens/fiat.png'],
            ['nome' => 'Volkswagen', 'imagem' => 'imagens/volkswagen.png'],
            ['nome' => 'Chevrolet', 'imagem' => 'imagens/chevrolet.png'],
            ['nome' => 'Ford', 'imagem' => 'imagens/ford.png'],
            ['nome' => 'Renault', 'imagem' => 'imagens/renault.png'],
            ['nome' => 'Toyota', 'imagem' => 'imagens/toyota.png'],
            ['nome' => 'Honda', 'imagem' => 'imagens/honda.png'],
            ['nome' => 'Hyundai', 'imagem' => 'imagens/hyundai.png'],
            ['nome' => 'Nissan', 'imagem' => 'imagens/nissan.png'],
            ['nome' => 'Jeep', 'imagem' => 'imagens/jeep.png'],
        ];

        foreach ($marcas as $marcaData) {
            Marca::firstOrCreate(
                ['nome' => $marcaData['nome']],
                $marcaData
            );
        }

        $this->command->info("   ✓ {$this->getCount(Marca::class)} marcas criadas");
    }

    /**
     * Get model count
     */
    private function getCount(string $model): int
    {
        return $model::count();
    }
}
