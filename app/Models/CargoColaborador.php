<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoColaborador extends Model
{
    use HasFactory;

    protected $table = 'cargos_colaborador';

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function colaboradorID()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
    }

   

}
