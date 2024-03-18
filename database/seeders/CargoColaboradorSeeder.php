<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CargoColaborador;
use Faker\Factory as Faker;

class CargoColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            CargoColaborador::create([
                'cargo_id' => random_int(1, 10),
                'colaborador_id' =>  random_int(1, 120),
                'nota_desempenho' => random_int(0, 10)
            ]);
        }
    }
}
