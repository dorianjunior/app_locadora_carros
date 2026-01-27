<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateCarroRequest extends FormRequest
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
        $carro = $this->route('carro');
        $carroId = $carro instanceof \App\Models\Carro ? $carro->id : $carro;

        return [
            'modelo_id' => 'sometimes|required|exists:modelos,id',
            'placa' => 'sometimes|required|string|unique:carros,placa,'.$carroId.'|max:10|regex:/^[A-Z]{3}-[0-9]{4}$/',
            'disponivel' => 'sometimes|required|boolean',
            'km' => 'sometimes|required|integer|min:0'
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
            'modelo_id.required' => 'O modelo é obrigatório',
            'modelo_id.exists' => 'O modelo selecionado não existe',
            'placa.required' => 'A placa é obrigatória',
            'placa.unique' => 'Já existe um carro com esta placa',
            'placa.max' => 'A placa deve ter no máximo :max caracteres',
            'placa.regex' => 'A placa deve estar no formato ABC-1234',
            'disponivel.required' => 'O status de disponibilidade é obrigatório',
            'disponivel.boolean' => 'O valor de disponibilidade deve ser verdadeiro ou falso',
            'km.required' => 'A quilometragem é obrigatória',
            'km.integer' => 'A quilometragem deve ser um número inteiro',
            'km.min' => 'A quilometragem não pode ser negativa',
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
