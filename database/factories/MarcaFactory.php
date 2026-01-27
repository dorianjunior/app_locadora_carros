<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarcaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->lexify('Marca ??????????'),
            'imagem' => 'imagens/marcas/default.jpg',
        ];
    }
}
