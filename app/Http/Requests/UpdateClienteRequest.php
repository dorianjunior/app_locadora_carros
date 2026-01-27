<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateClienteRequest extends FormRequest
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
        $cliente = $this->route('cliente');
        $clienteId = $cliente instanceof \App\Models\Cliente ? $cliente->id : $cliente;

        return [
            'nome' => 'sometimes|required|string|min:3|max:100',
            'email' => 'sometimes|required|email|unique:clientes,email,'.$clienteId.'|max:100',
            'cpf' => 'sometimes|required|string|digits:11|unique:clientes,cpf,'.$clienteId,
            'telefone' => 'sometimes|required|string|max:20',
            'endereco' => 'nullable|string|max:500'
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
            'nome.required' => 'O nome é obrigatório',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres',
            'nome.max' => 'O nome deve ter no máximo :max caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser válido',
            'email.unique' => 'Este e-mail já está cadastrado',
            'email.max' => 'O e-mail deve ter no máximo :max caracteres',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.digits' => 'O CPF deve conter :digits dígitos',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'telefone.required' => 'O telefone é obrigatório',
            'telefone.max' => 'O telefone deve ter no máximo :max caracteres',
            'endereco.max' => 'O endereço deve ter no máximo :max caracteres',
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
