<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {        

        // Szabályok megadása
        $rules['email'] = 'required|email:rfc,dns';           
        $rules['name'] = 'required';
        $rules['surname'] = 'required';
        $rules['forename'] = 'required';

        // Lekérdezni, hogy regisztrációról van-e szó
        $register = $this->request->get('register');

        // Ha igen
        if ($register == 1) {

            // 8 karakter, abból min 1 kis betű, min 1 nagybetű, min 1 szám és jelszó egyezőség is legyen
            $rules['password'] = 'required|same:confirm|min:8|regex:/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';

        } else {

            // Kötelező szerepkör megadása
            $rules['roles'] = 'required';

            // Jelszó ellenőrzése
            // Csak új felhasználó létrehozásakor legyen kötelező megadni!
            $id = $this->request->get('id');
            if ($id == 0) {
                $is_required = "required";
            } else {
                $is_required = "nullable";
            }

            // 8 karakter, abból min 1 kis betű, min 1 nagybetű, min 1 szám
        $rules['password'] = $is_required.'|min:8|regex:/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
        }

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'email.required' => 'E-mail cím megadása kötelező!',
           'email.email' => 'E-mail formátum nem megfelelő!',
           'name.required' => 'Név megadása kötelető!',
           'password.required' => 'Jelszó megadása kötelező!',
           'password.min' => 'Jelszó minimum 8 karaktert tartalmazhat!',
           'password.regex' => 'A jelszó legalább egy számot, legalább egy kis betűt és legalább egy nagy betűt kell tartalmaznia!',
           'password.same' => 'Nem egyezik meg a két jelszó!',
           'roles.required' => 'Legalább egy szerepkör megadása kötelező!',
           'surname.required' => 'Vezetéknév megadása kötelező!',
           'forename.required' => 'Keresztnév megadása kötelető!'
        ];
    }
}
