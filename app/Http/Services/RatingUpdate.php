<?php

namespace App\Http\Services;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingUpdate {

    public $id;
    private $user_id, $product_id, $title, $body, $stars;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->user_id = $request->user_id;
        $this->product_id = $request->product_id;
        $this->title = $request->title;
        $this->body = $request->body;
        $this->stars = $request->stars;   
        $this->updateRating();
    }

    // Értékelés felvitele
    private function updateRating() {
        DB::transaction(function () {

            // Megnézni, hogy volt-e már értékelése
            $rating = Rating::where('user_id', $this->user_id)->where('product_id', $this->product_id)->first();

            // Ha nem, akkor új értékelés felvitele
            if (!$rating) {
                $rating = new Rating();
            }   

            // Értékelés adatainak megadása
            $rating->user_id = $this->user_id;
            $rating->product_id = $this->product_id;
            $rating->title = $this->title;
            $rating->body = $this->body;
            $rating->stars = $this->stars;  
            $rating->moderated = 0;
            
            // Értékelés mentése
            $rating->save();

            // Azonosító lekérdezése
            $this->id = $rating->id;
        });
    }

}