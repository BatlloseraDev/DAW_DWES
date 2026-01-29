<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use App\Models\Parte;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('es_ES'); // Español (España)
        return [
            'nombre' => $faker->name,
            'cargo' => $faker->randomElement(['Profesor', 'Jefe de estudios', 'Tutor', 'Guardián de la luz de Ellendhil']),
            'departamento' => $this->faker->randomElement(['Informática', 'Administración', 'Educación Física', 'Frío y Calor', 'Física o Química']),
            'edad' => rand(18, 65),
            'observaciones' => $this->faker->text(100)
        ];
    }

    public function configure(): static
    {
        return $this
            ->afterCreating(function ($prof, $faker) {
                $numeroPartes = rand(0, 5); // Cambia esto al número deseado de partes por profesor.
                Parte::factory($numeroPartes)->create(['idProfesor' => $prof->id]);
            })
            // ->afterMaking(function ($profesor, $faker) {
            //    // Hacemos lo que sea con los datos del modelo del profesor antes de guardarlo definitivamente en la base de datos.
            //    // $profesor->save();
            // })
        ;
    }
}
