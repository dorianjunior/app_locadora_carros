<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'cpf', 'telefone', 'endereco'];

    public function rules() {
        return [
            'nome' => 'required|min:3|max:100',
            'email' => 'required|email|unique:clientes,email,' . ($this->id ?? 'NULL'),
            'cpf' => 'required|size:11|unique:clientes,cpf,' . ($this->id ?? 'NULL'),
            'telefone' => 'required|max:20',
            'endereco' => 'nullable|max:500'
        ];
    }

    public function locacoes() {
        return $this->hasMany('App\Models\Locacao');
    }
}
