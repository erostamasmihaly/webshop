<?php

namespace App\Http\Services;

use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ShopUpdate
{
    public $name;
    private $id, $summary, $body, $address, $url, $email, $telephone, $latitude, $longitude;

    // Adatok lekérdezése
    public function __construct(ShopUpdateRequest $shopUpdateRequest)
    {
        $this->id = $shopUpdateRequest->id;
        $this->name = $shopUpdateRequest->name;
        $this->summary = $shopUpdateRequest->summary;
        $this->body = $shopUpdateRequest->body;
        $this->address = $shopUpdateRequest->address;
        $this->url = $shopUpdateRequest->url;
        $this->email = $shopUpdateRequest->email;
        $this->telephone = $shopUpdateRequest->telephone;
        $this->latitude = $shopUpdateRequest->latitude;
        $this->longitude = $shopUpdateRequest->longitude;
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
            $shop->summary = $this->summary;
            $shop->body = $this->body;
            $shop->address = $this->address;
            $shop->email = $this->email;
            $shop->telephone = $this->telephone;
            $shop->latitude = $this->latitude;
            $shop->longitude = $this->longitude;
            $shop->url = $this->url;
            
            // Mentés
            $shop->save();

        });
    }
}