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
        $rules['price'] = 'required|min:0';
        $rules['quantity'] = 'required|min:0';
        $rules['category_id'] = 'required';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'name.required' => 'Név megadása kötelető!',
           'summary.required' => 'Rövid leírás megadása kötelető!',
           'body.required' => 'Bővebb leírás megadása kötelető!',
           'price' => 'Bruttó ár megadása kötelető és nem lehet kisebb, mint 0!',
           'quantity' => 'Mennyiség megadása kötelető és nem lehet kisebb, mint 0!',
           'category_id.required' => 'Kategória megadása kötelető!'
        ];
    }
}
