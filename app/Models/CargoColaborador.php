<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoColaborador extends Model
{
    use HasFactory;

    protected $table = 'cargos_colaborador';

    protected $fillable = ['cargo_id', 'colaborador_id', 'nota_desempenho'];

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'unidades');
    }

    public function colaboradorID()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
    }

 


    public function rules() {
        return [
            'cargo_id' => 'required|exists:cargos,id',
            'colaborador_id' => 'required|exists:colaboradores,id',
            'nota_desempenho' => 'required|integer|between:0,10',
        ];
    }
    

public function feedback() {
    return [
        'required' => 'O campo :attribute é obrigatório',
        'cargo_id.exists' => 'O cargo informado não existe',
        'nota_desempenho.integer' => 'O valor deve estar entre 0 e 10',
    ];
}  
}
