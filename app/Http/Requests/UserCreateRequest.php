<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
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
            'fk_type_user' => 'required',
            'document' => 'required|numeric|digits_between:3,10',
            'firstname' => 'required|min:3|max:50',
            'lastname' => 'required|min:3|max:50',
            'email' => 'required|unique:users,email|email|min:3|max:50',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|min:3|max:100',
            'password' => [
                'required',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
        ];
    }

    public function messages()
    {
        return [
            'document.required' => 'El campo documento es obligatorio.',
            'document.digits_between' => 'El campo documento debe tener entre 3 y 10 dígitos.',
            'firstname.required' => 'El campo nombres es obligatorio.',
            'firstname.min' => 'El campo nombres debe tener al menos 3 caracteres.',
            'firstname.max' => 'El campo nombres no debe tener más de 50 caracteres.',
            'lastname.required' => 'El campo apellidos es obligatorio.',
            'lastname.min' => 'El campo apellidos debe tener al menos 3 caracteres.',
            'lastname.max' => 'El campo apellidos no debe tener más de 50 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya ha sido registrado.',
            'email.min' => 'El campo correo electrónico debe tener al menos 3 caracteres.',
            'email.max' => 'El campo correo electrónico no debe tener más de 50 caracteres.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.digits' => 'El campo teléfono debe tener 10 dígitos.',
            'address.required' => 'El campo dirección es obligatorio.',
            'address.min' => 'El campo dirección debe tener al menos 3 caracteres.',
            'address.max' => 'El campo dirección no debe tener más de 50 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password' => 'El formato del campo contraseña no es válido. 
                1) El campo debe tener al menos ocho (8) caracteres. 
                2) El campo debe contener al menos una letra.
                3) El campo debe contener al menos un número.
                4) El campo debe contener al menos una letra mayúscula y una minúscula.
                5) El campo debe contener al menos un caracter especial.',
        ];
    }
}
