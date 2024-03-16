<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unidade;
use Faker\Factory as Faker;

class UnidadeSeeder extends Seeder
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
            Unidade::create([
                'nome_fantasia' => 'Unidade ' . ($i + 1),
                'razao_social' => 'Razão Social da Unidade ' . ($i + 1),
                'cnpj' => $faker->numerify('##############')
            ]);
        }
    }
}
