<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateMarcaRequest extends FormRequest
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
        $marcaId = $this->route('marca');

        return [
            'nome' => 'sometimes|required|string|unique:marcas,nome,'.$marcaId.'|min:3|max:100',
            'imagem' => 'sometimes|required|file|mimes:png,jpg,jpeg,gif,webp|max:2048'
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
            'nome.required' => 'O nome da marca é obrigatório',
            'nome.unique' => 'Já existe uma marca com este nome',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres',
            'nome.max' => 'O nome deve ter no máximo :max caracteres',
            'imagem.required' => 'A imagem é obrigatória',
            'imagem.file' => 'O arquivo deve ser uma imagem válida',
            'imagem.mimes' => 'A imagem deve ser PNG, JPG, JPEG, GIF ou WebP',
            'imagem.max' => 'A imagem deve ter no máximo 2MB',
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
