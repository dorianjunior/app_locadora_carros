<?php

namespace Database\Factories;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'modelo_id' => Modelo::factory(),
            'placa' => strtoupper($this->faker->bothify('???-####')),
            'disponivel' => $this->faker->boolean(70),
            'km' => $this->faker->numberBetween(0, 200000),
        ];
    }
}
