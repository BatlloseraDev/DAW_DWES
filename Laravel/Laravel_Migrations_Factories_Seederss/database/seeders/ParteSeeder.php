<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parte;


class ParteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Parte::factory()->count(7)->create();
    }
}
