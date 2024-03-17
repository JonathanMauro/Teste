<?php

namespace App\Observers;

use App\Models\Colaborador;
use App\Models\CargoColaborador;

class ColaboradorObserver
{
    /**
     * Handle the Colaborador "created" event.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    public function created(Colaborador $colaborador)
    {
          // Defina o ID do cargo aleatório entre 1 e 10
          $cargoId = rand(1, 10);

          // Crie um novo registro na tabela cargos_colaboradores
          CargoColaborador::create([
              'cargo_id' => $cargoId,
              'colaborador_id' => $colaborador->id,
              'nota_desempenho' => 0,
          ]);
    }

    /**
     * Handle the Colaborador "updated" event.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    public function updated(Colaborador $colaborador)
    {
        //
    }

    /**
     * Handle the Colaborador "deleted" event.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    public function deleted(Colaborador $colaborador)
    {
        //
    }

    /**
     * Handle the Colaborador "restored" event.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    public function restored(Colaborador $colaborador)
    {
        //
    }

    /**
     * Handle the Colaborador "force deleted" event.
     *
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    public function forceDeleted(Colaborador $colaborador)
    {
        //
    }
}
