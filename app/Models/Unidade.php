<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    protected $fillable = ['nome_fantasia', 'razao_social', 'cnpj'];

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class);
    }
//regras para cadastro e mensagens de erro
    public function rules() {
        return [
            'nome_fantasia' => 'required|unique:unidades',
            'razao_social' => 'required',
            'cnpj' => 'required|size:14' // Garante que o CNPJ tenha exatamente 14 caracteres
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da unidade já existe',
            'cpnj.size' => 'O cnpj deve ter 14 caracteres, numeros juntos sem espaço ou pontuação'
        ];
    }
}
