<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;


class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cargos = ['Porteiro(a)', 'Zelador(a)', 'Gerente', 'Promotor(a)', 'Psicologo(a)', 'Recepcionista', 'Segurança', 'Vendedor(a)', 'Motorista', 'Despachante']; // lista de cargos únicos

        // Iterar sobre cada cargo na lista
        foreach ($cargos as $cargo) {
            // Verificar se o cargo já existe na tabela
            if (!Cargo::where('cargo', $cargo)->exists()) {
                // Se não existe, criar um novo registro
                Cargo::create([
                    'cargo' => $cargo,
                ]);
            }
        }
    }
}
