<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerguntaRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação do formulário de pergunta.
     * - texto: obrigatório, string, mínimo de 10 caracteres, máximo de 255.
     */
    public function rules(): array
    {
        return [
            'texto' => ['required', 'string', 'min:10', 'max:255'],
        ];
    }

    /**
     * Mensagens customizadas de erro (exibidas via @error no Blade).
     */
    public function messages(): array
    {
        return [
            'texto.required' => 'Digite sua pergunta antes de enviar.',
            'texto.min' => 'Sua pergunta precisa ter pelo menos :min caracteres.',
            'texto.max' => 'Sua pergunta pode ter no máximo :max caracteres.',
        ];
    }
}
