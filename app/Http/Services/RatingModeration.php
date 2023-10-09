<?php

namespace App\Http\Services;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingModeration
{
    
    // Publikus adat
    public $id;

    // Privát adat
    private $moderated;

    // Adatok lekérdezése
    public function __construct(Request $request)
    {
        $this->id = $request->id;
        $this->moderated = $request->moderated;
        $this->changeModeration();
    }

    // Moderálás módosítása
    private function changeModeration() {

        DB::transaction(function () {
            $rating = Rating::find($this->id);
            $rating->moderated = $this->moderated;
            $rating->save();
        });
    }

}