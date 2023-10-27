<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartAddRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {

        // Szabályok megadása
        $rules['size_id'] = 'required';
        $rules['quantity'] = 'required';
        

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
            'size_id.required' => 'Méret megadása kötelező!',
            'quantity.required' => 'Mennyiség megadása kötelető!'
        ];
    }
}
