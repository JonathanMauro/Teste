<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ColaboradorObserver;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';

    protected $fillable = ['unidade_id', 'nome', 'cpf', 'email'];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'id', 'colaborador_id');
    }


    public function notasDesempenho()
    {
        return $this->hasMany(CargoColaborador::class, 'colaborador_id');
    }

//regras para cadastro e mensagens de erro
    public function rules() {
        return [
            'unidade_id' => 'required|exists:unidades,id',
            'nome' => 'required',
            'cpf' => 'required|unique:colaboradores',
            'email' => 'required|unique:colaboradores'
        ];
    }
    
    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unidade_id.exists' => 'A unidade informada não existe',
            'cpf.unique' => 'O CPF já está cadastrado',
            'email.unique' => 'O e-mail já está cadastrado'
        ];
    }   
    
    protected static function boot()
    {
        parent::boot();

        static::created(function ($colaborador) {
            // Lógica para criar um registro na tabela cargos_colaboradores
        });
    }

}
