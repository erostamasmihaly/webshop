<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RatingUser extends Notification
{
    use Queueable;

    private $shop, $user, $product, $moderated;

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
        $moderated = $this->moderated;
        $message = ($moderated==1) ? "Az alábbi termék esetén elfogadták az ön által megadott értékelést!" : "Az alábbi termék esetén elutasították az ön által megadott értékelést!";

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $user_name!")
                    ->line($message)
                    ->line("Termék neve: $product_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a megvásárolt terméket értékelte!");
    }

    // Normál értesítés
    public function toArray(object $notifiable): array
    {

        // Üzenet állapotfüggő legyen
        $message = ($this->moderated==1) ? "Termék értékelés el lett fogadva!" : "Termék értékelés el lett utasítva!";

        // Üzenet mentése
        return [
            'subject' => $message,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name
        ];
    }
}
