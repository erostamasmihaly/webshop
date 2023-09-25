<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnfavouriteShop extends Notification
{
    use Queueable;

    private $shop, $user, $product;

    // Adatok lekérdezése a kérésből
    public function __construct(Request $request)
    {
        $this->shop = $request->shop;
        $this->user = $request->user;
        $this->product = $request->product;         
    }

    // Megadni, hogy milyen formában hozza létre az értesítést
    public function via(object $notifiable): array
    {
        return ["mail","database"];
    }

    // E-mail értesítés
    public function toMail(object $notifiable): MailMessage
    {

        // Szükséges adatok lekérdezése
        $shop_name = $this->shop->name; 
        $user_name = $this->user->name;
        $product_name = $this->product->name;
        $product_id = $this->product->id;

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $shop_name!")
                    ->line("Az alábbi ön által árusított termék kedvencnek jelölését az egyik vásárló visszavonta!")
                    ->line("Termék neve: $product_name")
                    ->line("Vásárló felhasználói neve: $user_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a Rendszerünket használja!");
    }

    public function toArray(object $notifiable): array
    {
        // Szükséges adatok lekérdezése
        $shop_name = $this->shop->name; 
        $user_name = $this->user->name;
        $product_name = $this->product->name;
        $product_id = $this->product->id;
        
        // Üzenet szövegének összeállítása
        $body = "<ul><li>Termék neve: $product_name</li>
        <li>Vásárló felhasználói neve: $user_name</li></ul>";

        // Üzenet mentése
        return [
            'shop_name' => $shop_name,
            'subject' => 'Termék kedvelés vissza lett vonva!',
            'body' => $body,
            'product_id' => $product_id
        ];
    }
}
