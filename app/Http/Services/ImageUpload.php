<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ImageMod;

// Fényképek feltöltése
class ImageUpload {

    private $images, $product_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->images = $request->images;
        $this->product_id = $request->product_id;
        $this->upload();
    }

    // Sorrend módosítása
    private function upload () {
        DB::transaction(function() {   
            
            // Képek elmentése, ha volt
            if ($this->images!=null) {

                // Végigmenni minden egyes képen
                foreach ($this->images AS $image) {

                    // Lekérdezni a kép fájl nevét
                    $filename = $image->getClientOriginalName();
                    
                    // Kép eltárolása fizikailag
                    Storage::putFileAs(
                        'images/products/'.$this->product_id,
                        $image,
                        $filename
                    );

                    // Publikus átméretezett képek létrehozása
                    $this->createImage($this->product_id, $image, $filename);

                    // Legnagyobb sorrend lekérdezése
                    // Ha nincs ilyen kép, akkor 1-es sorrendű lesz, ha van, akkor egyel nagyobb
                    $max_sequence_image = Image::where('product_id',$this->product_id)->orderBy('sequence','desc')->first();
                    if ($max_sequence_image == null) {
                        $sequence = 1;
                    } else {
                        $sequence = ($max_sequence_image->sequence)+1;
                    }
                    
                    // Képet hozzárendelni az ingatlanhoz
                    $image = new Image();
                    $image->product_id = $this->product_id;
                    $image->filename = $filename;
                    $image->sequence = $sequence;
                    $image->save();
                }
            }

            // Vezérkép ellenőrzése
            $request = new Request();
            $request->setMethod('POST');
            $request->request->add(['product_id' => $this->product_id]);
            new ImageMainDefault($request);
        });
    }

    // Kép létrehozása
    private function createImage($product_id, $image, $name) {

        // Full HD-s kép
        $dir = public_path('images/products/'.$product_id);
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }
        $fullhd = ImageMod::make($image);            
        $fullhd->resize(1920, 1080, function ($const) {
            $const->aspectRatio();
        })->save($dir.'/'.$name);

        // 100x100-as kép
        $dir = public_path('images/products/'.$product_id.'/thumb');
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }
        $thumb = ImageMod::make($image);            
        $thumb->resize(100, 100, function ($const) {
            $const->aspectRatio();
        })->save($dir.'/'.$name);
    }

}