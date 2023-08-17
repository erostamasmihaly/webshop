<?php

namespace App\Http\Services;

use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ShopUpdate
{
    public $name;
    private $id;

    // Adatok lekérdezése
    public function __construct(ShopUpdateRequest $shopUpdateRequest)
    {
        $this->id = $shopUpdateRequest->id;
        $this->name = $shopUpdateRequest->name;
        $this->updateShop();
    }

    // Üzlet frissítése
    private function updateShop()
    {
        DB::transaction(function () {

            // Létrehozás vagy megnyitás
            if ($this->id==0) {
                $shop = new Shop();
            } else {
                $shop = Shop::find($this->id);
            }

            // További adatok módosítása
            $shop->name = $this->name;
            
            // Mentés
            $shop->save();

        });
    }
}