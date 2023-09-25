<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RatingShop extends Notification
{
    use Queueable;

    private $rating;

    // Adatok lekérdezése a kérésből
    public function __construct($rating)
    {
        $this->rating = $rating;         
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
        $shop_name = $this->rating->product->shop->name; 
        $user_name = $this->rating->user->name;
        $product_name = $this->rating->product->name;
        $product_id = $this->rating->product->id;
        $rating_stars = $this->rating->stars;
        $rating_title = $this->rating->title;
        $rating_body = $this->rating->boby;

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $shop_name!")
                    ->line("Az alábbi ön által árusított terméket értékelték!")
                    ->line("Termék neve: $product_name")
                    ->line("Értékelés: $rating_stars")
                    ->line("Cím: $rating_title")
                    ->line("Szöveg: $rating_body")
                    ->line("Vásárló felhasználói neve: $user_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a termékét a Rendszerünkön keresztül adta el!");
    }

    public function toArray(object $notifiable): array
    {
        // Szükséges adatok lekérdezése
        $shop_name = $this->rating->product->shop->name; 
        $user_name = $this->rating->user->name;
        $product_name = $this->rating->product->name;
        $product_id = $this->rating->product->id;
        $rating_stars = $this->rating->stars;
        $rating_title = $this->rating->title;
        $rating_body = $this->rating->boby;
        
        // Üzenet szövegének összeállítása
        $body = "<ul><li>Termék neve: $product_name</li>
        <li>Értékelés: $rating_stars</li>
        <li>Cím: $rating_title</li>
        <li>Szöveg: $rating_body</li>
        <li>Vásárló felhasználói neve: $user_name</li></ul>";

        // Üzenet mentése
        return [
            'shop_name' => $shop_name,
            'subject' => 'Értékelés történt!',
            'body' => $body,
            'product_id' => $product_id
        ];
    }
}
