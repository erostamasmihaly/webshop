<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Favourite;
use App\Models\Image;
use App\Models\Payment;
use App\Models\Position;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\Rating;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class AdminIndexController extends Controller
{

    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Admin főoldal
    public function index()
    {

        // Oldal meghívása
        return view('admin.index');
    }

    // Tevékenység napló
    public function log()
    {

        // Naplóbejegyzések betöltése
        $logs = Activity::orderBy('created_at','desc')->get();

        // Végigmenni minden egyes bejegyzésen
        foreach ($logs AS $log) {

            // Lekérdezni a létrehozó felhasználó nevét
            $log->causer_name = $this->subject_name("App\Models\User", $log->causer_id, null); 

            // Lekérdezni a módosított elem nevét
            $log->subject_name = $this->subject_name($log->subject_type, $log->subject_id, $log->properties);
        }

        // Oldal meghívása
        return view('admin.log', [
            'logs' => $logs
        ]);
    }

    // Módosított elem nevének lekérdezése
    private function subject_name($subject_type, $subject_id, $properties) {
        $return = $subject_id;
        $array = json_decode($properties, TRUE);
        switch ($subject_type) {
            case "App\Models\User":
                $return = (User::find($subject_id)) ? User::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\CategoryGroup": 
                $return = (CategoryGroup::find($subject_id)) ? CategoryGroup::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\Category":
                $return = (Category::find($subject_id)) ? Category::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\Cart":
                break;
            case "App\Models\Favourite":
                if (isset($array["attributes"]["product_id"])) {
                    $product = Product::find($array["attributes"]["product_id"]);
                } else {
                    $product = Product::find($array["old"]["product_id"]);
                }
                $return = ($product) ? $product->name : "-";
                break;
            case "App\Models\Image":
                $image = Image::find($subject_id);
                if ($image) {
                    $product = Product::find($image->product_id);
                    if ($product) {
                        $return = $product->name." >> ".$image->filename;
                    }
                } 
                break;
            case "App\Models\Payment":
                $return = (Payment::find($subject_id)) ? Payment::find($subject_id)->order_ref : $subject_id;
                break;
            case "App\Models\Position":
                $return = (Position::find($subject_id)) ? Position::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\Product": 
                $return = (Product::find($subject_id)) ? Product::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\ProductCategory":
                $product_category = ProductCategory::find($subject_id);
                if ($product_category) {
                    $product = $product_category->product;
                    $category = Category::find($array["attributes"]["category_id"]);
                    $product_name = ($product) ? $product->name : "-";
                    $category_name = ($category) ? $category->name : "-";
                    $return = "$product_name >> $category_name"; 
                }
                break;
            case "App\Models\ProductPrice": 
                $product_price = ProductPrice::find($subject_id);
                if ($product_price) {
                    $product = $product_price->product;
                    if ($product) {
                        $return = $product->name;
                    }
                }
                break;
            case "App\Models\Rating": 
                $rating = Rating::find($subject_id);
                if ($rating) {
                    $product = $rating->product;
                    if ($product) {
                        $return = $product->name;
                    }
                }
                break;
            case "App\Models\Role": 
                $return = (Role::find($subject_id)) ? Role::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\Shop": 
                $return = (Shop::find($subject_id)) ? Shop::find($subject_id)->name : $subject_id;
                break;
            case "App\Models\UserPosition": 
                break;
            case "App\Models\UserRole": 
                break;
        }

        return $return;
    }
    
}
