<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {

        // Szabályok megadása
        $rules['name'] = 'required';
        $rules['summary'] = 'required';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'name' => 'Név megadása kötelező!',
           'summary' => 'Rövid leírás megadása kötelező!'
        ];
    }
}
