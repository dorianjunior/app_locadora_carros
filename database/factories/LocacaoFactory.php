<?php

namespace Database\Factories;

use App\Models\Carro;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $dataInicio = now()->addDays($this->faker->numberBetween(1, 30));
        $dataFim = (clone $dataInicio)->addDays($this->faker->numberBetween(1, 15));

        return [
            'cliente_id' => Cliente::factory(),
            'carro_id' => Carro::factory(),
            'data_inicio_periodo' => $dataInicio,
            'data_final_previsto_periodo' => $dataFim,
            'data_final_realizado_periodo' => null,
            'valor_diaria' => $this->faker->randomFloat(2, 50, 500),
            'km_inicial' => $this->faker->numberBetween(0, 100000),
            'km_final' => null,
        ];
    }
}
