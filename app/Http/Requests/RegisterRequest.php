<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'direction' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers()
            ]
        ];
    }

    public function messages()
    {
        return[
            'name' => '¿Cómo te llamamos?',
            'direction' => '¿Dónde mandamos tus pedidos?',
            'phone' => '¿Cómo te localizamos en caso de necesidad?',
            'email.required' => 'Necesitamos tu email para el registro',
            'email.email' => 'Este email no es válido',
            'email.unique' => 'Este email ya esta registrado',
            'password' => 'La contraseña debe tener un mínimo de 8 caracteres con letras y números'
        ];
    }
}
