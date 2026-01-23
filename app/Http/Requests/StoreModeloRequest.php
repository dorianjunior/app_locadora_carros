<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreModeloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'marca_id' => 'required|exists:marcas,id',
            'nome' => 'required|string|unique:modelos,nome|min:3|max:100',
            'imagem' => 'required|file|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'numero_portas' => 'required|integer|min:2|max:5',
            'lugares' => 'required|integer|min:2|max:20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'marca_id.required' => 'A marca é obrigatória',
            'marca_id.exists' => 'A marca selecionada não existe',
            'nome.required' => 'O nome do modelo é obrigatório',
            'nome.unique' => 'Já existe um modelo com este nome',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres',
            'nome.max' => 'O nome deve ter no máximo :max caracteres',
            'imagem.required' => 'A imagem é obrigatória',
            'imagem.file' => 'O arquivo deve ser uma imagem válida',
            'imagem.mimes' => 'A imagem deve ser PNG, JPG, JPEG, GIF ou WebP',
            'imagem.max' => 'A imagem deve ter no máximo 2MB',
            'numero_portas.required' => 'O número de portas é obrigatório',
            'numero_portas.integer' => 'O número de portas deve ser um número inteiro',
            'numero_portas.min' => 'O número de portas deve ser no mínimo :min',
            'numero_portas.max' => 'O número de portas deve ser no máximo :max',
            'lugares.required' => 'O número de lugares é obrigatório',
            'lugares.integer' => 'O número de lugares deve ser um número inteiro',
            'lugares.min' => 'O número de lugares deve ser no mínimo :min',
            'lugares.max' => 'O número de lugares deve ser no máximo :max',
            'air_bag.required' => 'A informação sobre air bag é obrigatória',
            'air_bag.boolean' => 'O valor de air bag deve ser verdadeiro ou falso',
            'abs.required' => 'A informação sobre ABS é obrigatória',
            'abs.boolean' => 'O valor de ABS deve ser verdadeiro ou falso',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
