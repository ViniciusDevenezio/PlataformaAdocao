<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ong_id' => 1, // ajuste se tiver ONGs diferentes
            'nome' => $this->faker->firstName,
            'raca' => $this->faker->word,
            'mistura' => $this->faker->boolean,
            'misturado_com' => $this->faker->word,
            'temperamento' => $this->faker->randomElement(['calmo', 'agitado', 'brincalhão']),
            'porte' => $this->faker->randomElement(['pequeno', 'medio', 'grande']),
            'genero' => $this->faker->randomElement(['Macho', 'Femea']),
            'faixa_etaria' => $this->faker->randomElement(['Filhote', 'Adulto', 'Idoso']),
            'localizacao' => $this->faker->city,
            'disponivel_ate' => now()->addDays(30),
            'status' => 'disponivel',
            'imagem_url' => 'https://via.placeholder.com/150',
            'descricao' => $this->faker->sentence,
        ];
    }
}
