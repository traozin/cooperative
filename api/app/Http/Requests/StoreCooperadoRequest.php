<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCooperadoRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'nome' => ['required', 'string'],
            'cpf_cnpj' => ['required', 'string', 'unique:cooperados,cpf_cnpj'],
            'data_nascimento_constituicao' => ['required', 'date'],
            'renda_faturamento' => ['required', 'numeric'],
            'telefone' => ['required', 'string'],
            'email' => ['nullable', 'email'],
        ];
    }
}
