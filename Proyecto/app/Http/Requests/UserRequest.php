<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname'=>'required|regex:/^[a-z\d\-_\ZñÑáéíóúÁÉÍÓÚ\s]+$/i',
            'lastname'=>'required|regex:/^[a-z\d\-_\ZñÑáéíóúÁÉÍÓÚ\s]+$/i',
            'nick'=>'required|text',
            'password'=>'required|text',
        ];
    }

    public function messages()
    {
        return [
            'firstname.required'=>'El campo Nombres es requerido',
            'lastname.required'=>'El campo Apellidos es requerido',
            'nick.required'=>'El campo Nick es requerido',
            'password.required'=>'El campo Contraseña es requerido'
        ];
    }

    public function attributes()
    {
        return [
            'firstname'=>'Nombres',
            'lastname'=>'Apellidos',
            'nick'=>'Nick',
            'password'=>'Contraseña'
        ];
    }
}
