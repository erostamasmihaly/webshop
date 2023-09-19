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
        $rules['vat'] = 'required|min:0';
        $rules['discount'] = 'required|min:0';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'name' => 'Név megadása kötelető!',
           'summary' => 'Rövid leírás megadása kötelető!',
           'body.' => 'Bővebb leírás megadása kötelető!',
           'price' => 'Bruttó ár megadása kötelető és nem lehet kisebb, mint 0!',
           'quantity' => 'Mennyiség megadása kötelető és nem lehet kisebb, mint 0!',
           'vat'=> 'ÁFA megadáda kötelező és nem lehet kisebb, mint 0!',
           'discount' => 'Kedvezmény megadáda kötelező és nem lehet kisebb, mint 0!'
        ];
    }
}
