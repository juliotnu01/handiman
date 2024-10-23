<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EspecialistaRequest extends FormRequest
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
            "numero_identificacion" => "unique:especialistas,numero_identificacion",
            "correo" => "unique:especialistas,correo"
        ];
    }
    public function messages(): array
    {
        return [
            'numero_identificacion.unique' => 'Este número de identificación ya está registrado.',
            'correo.unique' => 'Este correo electrónico ya está en uso.'
        ];
    }
}
