<?php

namespace App\Http\Services;

use App\Models\Image;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

// Képek törlése
class ImageDelete {

    private $image_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->image_id = $request->image_id;
        $this->main();
    }

    // Kép törlése
    private function main () {
        DB::transaction(function() {

            // Lekérdezni a mostani képet a két helyről
            $image = Image::where('id', $this->image_id)->first();
            
            // Lekérdezni a képpel kapcsolatban néhány adatot
            $product_id = $image->product_id;
            $sequence = $image->sequence;
            $is_main = $image->is_main;
            $filename = $image->filename;

            // Ezen kép törlése mindenhol
            $image->delete();

            // Kép törlése
            File::delete('images/products/'.$product_id.'/'.$filename);
            File::delete('images/products/'.$product_id.'/thumb/'.$filename);
            Storage::delete('images/products/'.$product_id.'/'.$filename);

            // Ha vezérkép volt, akkor annak is a törlése
            if ($is_main==1) {
                File::delete('images/products/'.$product_id.'/main_image.jpg');
            }

            // Minden egyes későbbi kép esetén a sorrend csökkentése egyel
            $db_images = Image::where('product_id',$product_id)->where('sequence','>',$sequence)->get();
            foreach ($db_images AS $db_image) {                
                $db_image->sequence = $db_image->sequence-1;
                $db_image->save();
            }  
            
            // Vezérkép ellenőrzése
            $request = new Request();
            $request->setMethod('POST');
            $request->request->add(['product_id' => $product_id]);
            new ImageMainDefault($request);

        });
    }

}