<?php

namespace App\Http\Services;

use App\Http\Requests\PositionUpdateRequest;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionUpdate
{

    private $id, $shop_id, $summary, $body;
    public $name;

    // Adatok lekérdezése
    public function __construct(PositionUpdateRequest $positionUpdateRequest)
    {
        $this->id = $positionUpdateRequest->id;
        $this->name = $positionUpdateRequest->name;
        $this->shop_id = $positionUpdateRequest->shop_id;
        $this->summary = $positionUpdateRequest->summary;
        $this->body = $positionUpdateRequest->body;
        $this->updatePosition();
    }

    // Munkakör módosítása
    private function updatePosition() {

        // Létrehozás vagy megnyitás
        if ($this->id==0) {
            $position = new Position();
        } else {
            $position = Position::find($this->id);
        }

        // További adatok megadása
        $position->name = $this->name;
        $position->shop_id = $this->shop_id;
        $position->summary = $this->summary;
        $position->body = $this->body;

        // Mentés
        $position->save();
    }
}