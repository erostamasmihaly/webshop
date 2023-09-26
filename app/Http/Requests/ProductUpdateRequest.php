<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        $rules['body'] = 'required';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'name' => 'Név megadása kötelető!',
           'summary' => 'Rövid leírás megadása kötelető!',
           'body' => 'Bővebb leírás megadása kötelető!'
        ];
    }
}
