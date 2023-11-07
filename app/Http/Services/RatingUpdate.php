<?php

namespace App\Http\Services;

use App\Http\Requests\RatingUpdateRequest;
use App\Models\Rating;
use App\Models\RatingImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RatingUpdate {

    public $id;
    private $user_id, $product_id, $title, $body, $stars, $images;

    // Adatok lekérdezése
    function __construct(RatingUpdateRequest $ratingUpdateRequest) {
        $this->user_id = Auth::id();
        $this->product_id = $ratingUpdateRequest->product_id;
        $this->title = $ratingUpdateRequest->title;
        $this->body = $ratingUpdateRequest->body;
        $this->stars = $ratingUpdateRequest->stars;   
        $this->images = $ratingUpdateRequest->images;
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

            // Fényképek felvitele
            $this->uploadImages();
        });
    }

    // Fényképek felvitele
    private function uploadImages() {

        // Képek elmentése, ha volt
        if ($this->images!=null) {

            // Végigmenni minden egyes képen
            foreach ($this->images AS $image) {

                // Lekérdezni a kép fájl nevét
                $filename = $image->getClientOriginalName();
                
                // Kép eltárolása fizikailag
                Storage::putFileAs(
                    'images/ratings/'.$this->id,
                    $image,
                    $filename
                );

                // Publikus átméretezett képek létrehozása
                $this->createImage($image, $filename);
                
                // Képet hozzárendelni az ingatlanhoz
                $image = new RatingImage();
                $image->product_id = $this->id;
                $image->filename = $filename;
                $image->save();
            }
        }
    }

    // Kép létrehozása
    private function createImage($image, $name) {

        // Full HD-s kép
        $dir = public_path('images/ratings/'.$this->id);
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }
        $fullhd = ImageMod::make($image);            
        $fullhd->resize(1920, 1080, function ($const) {
            $const->aspectRatio();
        })->save($dir.'/'.$name);

        // 150x150-es kép
        $dir = public_path('images/ratings/'.$this->id.'/thumb');
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }
        $thumb = ImageMod::make($image);            
        $thumb->resize(150, 150, function ($const) {
            $const->aspectRatio();
        })->save($dir.'/'.$name);
    }

}