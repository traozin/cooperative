<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCooperadoRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'nome' => ['required', 'string'],
            'cpf_cnpj' => [
                'required',
                Rule::unique('cooperados', 'cpf_cnpj')->ignore($this->route('cooperado'))
            ],
            'data_nascimento_constituicao' => ['required', 'date'],
            'renda_faturamento' => ['required', 'numeric'],
            'telefone' => ['required', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'email' => ['nullable', 'email'],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $validator->errors(),
        ], 422));
    }

    public function attributes(): array {
        return [
            'nome' => 'Nome',
            'cpf_cnpj' => 'CPF/CNPJ',
            'data_nascimento_constituicao' => 'Data de nascimento ou constituição',
            'renda_faturamento' => 'Renda ou faturamento',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
        ];
    }

    public function messages(): array {
        return [
            'telefone.regex' => 'O campo Telefone deve ser um número válido, como (11) 99999-9999.',
            'cpf_cnpj.unique' => 'Já existe um cooperado com este CPF/CNPJ cadastrado.',
        ];
    }
}
