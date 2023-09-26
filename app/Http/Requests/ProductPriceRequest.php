<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {

        // Szabályok megadása
        $rules['price'] = 'required|min:0';
        $rules['quantity'] = 'required|min:1';
        $rules['vat'] = 'required|min:0';
        $rules['discount'] = 'required|min:0';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'price' => 'Bruttó ár megadása kötelető és nem lehet kisebb, mint 0!',
           'quantity' => 'Mennyiség megadása kötelető és nem lehet kisebb, mint 1!',
           'vat'=> 'ÁFA megadása kötelező és nem lehet kisebb, mint 0!',
           'discount' => 'Kedvezmény megadása kötelező és nem lehet kisebb, mint 0!'
        ];
    }
}
