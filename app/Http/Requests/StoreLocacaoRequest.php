<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreLocacaoRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required|date|after_or_equal:today',
            'data_final_previsto_periodo' => 'required|date|after:data_inicio_periodo',
            'data_final_realizado_periodo' => 'nullable|date',
            'valor_diaria' => 'required|numeric|min:0|max:9999.99',
            'km_inicial' => 'required|integer|min:0',
            'km_final' => 'nullable|integer|min:0|gte:km_inicial'
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
            'cliente_id.required' => 'O cliente é obrigatório',
            'cliente_id.exists' => 'O cliente selecionado não existe',
            'carro_id.required' => 'O carro é obrigatório',
            'carro_id.exists' => 'O carro selecionado não existe',
            'data_inicio_periodo.required' => 'A data de início é obrigatória',
            'data_inicio_periodo.date' => 'A data de início deve ser uma data válida',
            'data_inicio_periodo.after_or_equal' => 'A data de início não pode ser no passado',
            'data_final_previsto_periodo.required' => 'A data de devolução prevista é obrigatória',
            'data_final_previsto_periodo.date' => 'A data de devolução prevista deve ser uma data válida',
            'data_final_previsto_periodo.after' => 'A data de devolução deve ser posterior à data de início',
            'data_final_realizado_periodo.date' => 'A data de devolução realizada deve ser uma data válida',
            'valor_diaria.required' => 'O valor da diária é obrigatório',
            'valor_diaria.numeric' => 'O valor da diária deve ser um número',
            'valor_diaria.min' => 'O valor da diária não pode ser negativo',
            'valor_diaria.max' => 'O valor da diária deve ser no máximo :max',
            'km_inicial.required' => 'A quilometragem inicial é obrigatória',
            'km_inicial.integer' => 'A quilometragem inicial deve ser um número inteiro',
            'km_inicial.min' => 'A quilometragem inicial não pode ser negativa',
            'km_final.integer' => 'A quilometragem final deve ser um número inteiro',
            'km_final.min' => 'A quilometragem final não pode ser negativa',
            'km_final.gte' => 'A quilometragem final deve ser maior ou igual à quilometragem inicial',
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
