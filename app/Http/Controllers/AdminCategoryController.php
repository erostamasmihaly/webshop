<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryUpdate;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

class AdminCategoryController extends Controller
{
    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Kategóriák listája
    public function index() {

        // Kategóriák lekérdezése
        $categories = Category::get();

        // Oldal meghívása
        return view('admin.category',[
            'categories' => $categories
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
        return redirect()->route('admin_category')->withMessage($categoryUpdate->name.' sikeresen módosítva lett.');
    }

    // Új kategória létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('admin_category_edit', 0);

    }

    // Sorrend módosítása felület
    public function sequence() {

        // Oldal meghívása
        return view('admin.category_sequence');

    }

    // Aktuális sorrend betöltése
    public function sequence_load() {

        // Kategóriák lekérdezése
        $categories = Category::orderBy("sequence")->get();

        foreach($categories AS $category) {
            $category->level = count(get_category_parents($category->id));
        }

        // Visszatérés ezen tömbbel
        return Response::json($categories);

    }

    // Sorrend mentése
    public function sequence_save() {

    }
}
