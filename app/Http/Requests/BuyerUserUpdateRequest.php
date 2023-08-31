<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BuyerUserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // Validálási szabályok
    public function rules() {       
        
        // Lekérdezni a felhasználói nevet és az azonosítót
        $name = $this->request->get('name');
        $id = $this->request->get('id');

        // Megnézni, hogy ezen felhasználói név szerepel-e úgy, hogy nem ezen felhasználó esetén
        $is_exists = User::where('name', $name)->where('id','!=',$id)->first();
        if ($is_exists) {

            // Ha létezik, akkor berakni  a szabályok közé az egyediséget is
            $rules['name'] = 'required|unique:users|regex:/^[a-z0-9\.]+$/';

        } else {

            // Ha pedig nem létezik, akkor a többi szabály elég lesz
            $rules['name'] = 'required|regex:/^[a-z0-9\.]+$/';
        }

        // Szabályok megadása       
        $rules['surname'] = 'required';
        $rules['forename'] = 'required';

        // Visszatérés a szabályokkal
        return $rules;
    }

    // Validálási hibaüzenetek
    public function messages() {
        return [
           'name.required' => 'Név megadása kötelető!',
           'surname.required' => 'Vezetéknév megadása kötelező!',
           'forename.required' => 'Keresztnév megadása kötelető!',
           'name.unique' => 'Ezen felhasználói név foglalt, kérem válasszon másikat!',
           'name.regex' => 'Felhasználói név csak az angol ABC kis betűit, számot és pontot tartalmazhat!'
        ];
    }
}
