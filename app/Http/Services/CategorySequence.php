<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Sorrend elmentése
class CategorySequence {

    private $categories, $category_group_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->categories = $request->categories;
        $this->category_group_id = $request->category_group_id;
        $this->main();
    }

    // Sorrend módosítása
    private function main () {
        DB::transaction(function() {

            // JSON átalakítása tömbbé
            $array = json_decode($this->categories, TRUE);

            // Végigmenni minden egyes képen
            for ($i=0; $i<count($array); $i++) {
                
                // Felvinni a képet az új sorrenddel
                Category::where('id', $array[$i]['id'])->update(['sequence' => $i+1, 'category_id' => $array[$i]['category_id']]);
            }

            // Felhasználó lekérdezése
            $user = User::find(Auth::id());

            // Ingatlan lekérdezése
            $category_group = CategoryGroup::find($this->category_group_id);

            // Naplózás
            if ($category_group!=null) {
                activity()->causedBy($user)->performedOn($category_group)->withProperties(['attributes' => $array])->event('category_sequence')->log('category_sequence');
            }

        });
    }

}