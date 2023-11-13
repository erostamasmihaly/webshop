<?php

namespace App\Http\Services;

use App\Models\RatingImage;
use Illuminate\Support\Facades\DB;

class RatingImageDelete {
    
    // Privát adat
    private $id;

    // Adatok lekérdezése
    public function __construct($id)
    {
        $this->id = $id;
        $this->deleteImage();
    }

    // Kép törlése
    private function deleteImage() {

        DB::transaction(function () {
            $image = RatingImage::find($this->id);
            $image->delete();
        });
    }

}