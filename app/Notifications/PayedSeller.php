<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayedSeller extends Notification
{
    use Queueable;

    private $shop, $user, $cart;

    // Adatok lekérdezése a kérésből
    public function __construct(Request $request)
    {
        $this->shop = $request->shop;
        $this->user = $request->user;
        $this->cart = $request->cart;         
    }

    // Megadni, hogy milyen formában hozza létre az értesítést
    public function via(object $notifiable): array
    {
        return ["mail"];
    }

    // E-mail értesítés
    public function toMail(object $notifiable): MailMessage
    {

        // Szükséges adatok lekérdezése
        $shop_name = $this->shop->name; 
        $user_name = $this->user->name;
        $product_name = $this->cart->product->name;
        $product_quantity = $this->cart->quantity;
        $product_unit = $this->cart->product->unit->category->name;
        $product_price =  $this->cart->price;
        $product_id = $this->cart->product->id;

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $shop_name!")
                    ->line("Az alábbi ön által árusított termék sikeresen megvásárolásra került:")
                    ->line("Termék neve: $product_name")
                    ->line("Vásárolt mennyiség: $product_quantity $product_unit")
                    ->line("Egységár a vásárlás során: $product_price")
                    ->line("Vásárló felhasználói neve: $user_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a termékét a Rendszerünkön keresztül adta el!");
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
