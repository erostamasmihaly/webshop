<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FavouriteShop extends Notification
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
                    ->line("Az alábbi ön által árusított terméket az egyik vásárló kedvencnek jelölte!")
                    ->line("Termék neve: $product_name")
                    ->line("Vásárló felhasználói neve: $user_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a Rendszerünket használja!");
    }

    // Normál értesítés
    public function toArray(object $notifiable): array
    {

        // Üzenet mentése
        return [
            'shop_id' => $this->shop->id,
            'shop_name' => $this->shop->name,
            'subject' => 'Termék kedvelve lett!',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name
        ];
    }
}
