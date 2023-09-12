<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryGroupUpdate;
use App\Http\Services\CategoryUpdate;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Support\Facades\Response;

class AdminCategoryController extends Controller
{
    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Kategóriák listája
    public function index($category_group_id) {

        // Kategóriák lekérdezése
        $categories = Category::where('category_group_id', $category_group_id)->orderBy('sequence')->get();

        // Oldal meghívása
        return view('admin.category',[
            'categories' => $categories,
            'category_group_id' => $category_group_id
        ]);
    }    

    // Kategória szerkesztése
    public function edit($id) {

        if ($id==0) {
            
            // Új kategória
            $category = new Category();
            $category->id = 0;

        } else {
        
            // Kategória adatainak lekérdezése
            $category = Category::find($id);
        }

        // Összes kategória lekérdezése
        $parents = Category::get();

        // Oldal meghívása
        return view('admin.category_edit',[
            'category' => $category,
            'parents' => $parents
        ]);
    }

    // Kategória módosítása
    public function update(CategoryUpdate $categoryUpdate) {
        return redirect()->route('admin_category', $categoryUpdate->category_group_id)->withMessage($categoryUpdate->name.' sikeresen módosítva lett.');
    }

    // Új kategória létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('admin_category_edit', 0);

    }

    // Sorrend módosítása felület
    public function sequence($category_group_id) {

        // Oldal meghívása
        return view('admin.category_sequence', [
            'category_group_id' => $category_group_id
        ]);

    }

    // Aktuális sorrend betöltése
    public function sequence_load($category_group_id) {

        // Kategóriák lekérdezése
        $categories = Category::where('category_group_id', $category_group_id)->orderBy("sequence")->get();

        foreach($categories AS $category) {
            $category->level = count(get_category_parents($category->id));
        }

        // Visszatérés ezen tömbbel
        return Response::json($categories);

    }

    // Sorrend mentése
    public function sequence_save() {

    }

    // Kategória csoportok listája
    public function group_index() {

        // Kategóriák lekérdezése
        $category_groups = CategoryGroup::get();

        // Oldal meghívása
        return view('admin.category_group',[
            'category_groups' => $category_groups
        ]);
    }    

    // Kategória csoport szerkesztése
    public function group_edit($id) {

        if ($id==0) {
            
            // Új kategória csoport
            $category_group = new CategoryGroup();
            $category_group->id = 0;

        } else {
        
            // Kategória csoport adatainak lekérdezése
            $category_group = CategoryGroup::find($id);
        }

        // Oldal meghívása
        return view('admin.category_group_edit',[
            'category_group' => $category_group
        ]);
    }

    // Kategória csoport módosítása
    public function group_update(CategoryGroupUpdate $categoryGroupUpdate) {
        return redirect()->route('admin_category_group')->withMessage($categoryGroupUpdate->name.' sikeresen módosítva lett.');
    }

    // Új kategória csoport létrehozása
    public function group_create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('admin_category_group_edit', 0);

    }
}
