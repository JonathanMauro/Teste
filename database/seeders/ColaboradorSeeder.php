<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colaborador;
use Faker\Factory as Faker;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 120; $i++) {
            Colaborador::create([
                'unidade_id' => random_int(1, 100),
                'nome' => $faker->name,
                'cpf' => $faker->numerify('###########'),
                'email' => $faker->email,
            ]);
        }
    }
}
