<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {

        // Szabályok megadása
        $rules['images'] = 'nullable';
        $rules['images.*'] = 'mimes:jpg,jpeg,png|max:51200';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'images.*.mimes' => 'Csak JPG és PNG formátumú fájlok tölthetőek fel!',
           'images.*.max' => 'Maximális megengedett fájlméret 50 MB!'
        ];
    }
}
