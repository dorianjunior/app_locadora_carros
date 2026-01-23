<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem','numero_portas','lugares','air_bag','abs'];

    public function rules()
    {
        return  [
            'marca_id' => 'required|exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3|max:100',
            'imagem' => 'required|file|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'numero_portas' => 'required|integer|min:2|max:5',
            'lugares' => 'required|integer|min:2|max:20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function feedback()
    {
        return [
            'marca_id.required' => 'A marca é obrigatória',
            'marca_id.exists' => 'A marca selecionada não existe',
            'nome.required' => 'O nome do modelo é obrigatório',
            'nome.unique' => 'Já existe um modelo com este nome',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'nome.max' => 'O nome deve ter no máximo 100 caracteres',
            'imagem.required' => 'A imagem é obrigatória',
            'imagem.file' => 'O arquivo deve ser uma imagem válida',
            'imagem.mimes' => 'A imagem deve ser PNG, JPG, JPEG, GIF ou WebP',
            'imagem.max' => 'A imagem deve ter no máximo 2MB',
            'numero_portas.required' => 'O número de portas é obrigatório',
            'numero_portas.integer' => 'O número de portas deve ser um número inteiro',
            'numero_portas.min' => 'O número de portas deve ser no mínimo 2',
            'numero_portas.max' => 'O número de portas deve ser no máximo 5',
            'lugares.required' => 'O número de lugares é obrigatório',
            'lugares.integer' => 'O número de lugares deve ser um número inteiro',
            'lugares.min' => 'O número de lugares deve ser no mínimo 2',
            'lugares.max' => 'O número de lugares deve ser no máximo 20',
            'air_bag.required' => 'A informação sobre air bag é obrigatória',
            'air_bag.boolean' => 'O valor de air bag deve ser verdadeiro ou falso',
            'abs.required' => 'A informação sobre ABS é obrigatória',
            'abs.boolean' => 'O valor de ABS deve ser verdadeiro ou falso',
        ];
    }

    public function marca() {
        return $this->belongsTo('App\Models\Marca');
    }

    public function carros() {
        return $this->hasMany('App\Models\Carro');
    }
}
