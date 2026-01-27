<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'marca_id' => Marca::factory(),
            'nome' => $this->faker->word() . ' ' . $this->faker->randomNumber(3),
            'imagem' => 'imagens/modelos/default.jpg',
            'numero_portas' => $this->faker->numberBetween(2, 4),
            'lugares' => $this->faker->numberBetween(2, 7),
            'air_bag' => $this->faker->boolean(80),
            'abs' => $this->faker->boolean(90),
        ];
    }
}
