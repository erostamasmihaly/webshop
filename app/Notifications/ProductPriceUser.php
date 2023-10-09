<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductPriceUser extends Notification
{
    use Queueable;

    private $shop, $user, $product;

    // Adatok lekérdezése a kérésből
    public function __construct(Request $request)
    {
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
        $user_name = $this->user->name;
        $product_name = $this->product->name;
        $product_id = $this->product->id;

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $user_name!")
                    ->line("Az egyik ön által kedvelt termék ára módosult!")
                    ->line("Termék neve: $product_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a terméket kedvelte!");
    }

    // Normál értesítés
    public function toArray(object $notifiable): array
    {

        // Üzenet mentése
        return [
            'subject' => 'Kedvelt termék ára módosult!',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name
        ];
    }
}
