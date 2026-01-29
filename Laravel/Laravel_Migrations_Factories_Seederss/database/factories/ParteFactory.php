<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profesor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parte>
 */
class ParteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno' => $this->faker->name,
            'gravedad' => $this->faker->randomElement(['Leve', 'Grave', 'Destierro', 'Latigazos', 'Pasar por la quilla']),
            'idProfesor' => $this->faker->randomElement(Profesor::get('id')),
            'observaciones' => $this->faker->text(100)
        ];
    }
}
