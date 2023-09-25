<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentShop extends Notification
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
        return ["mail","database"];
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
        $product_price =  numformat_with_unit($this->cart->price,"Ft");
        $product_id = $this->cart->product->id;

        // Üzenet létrehozása
        return (new MailMessage)
                    ->greeting("Tisztelt $shop_name!")
                    ->line("Az alábbi ön által árusított termék sikeresen megvásárolásra került!")
                    ->line("Termék neve: $product_name")
                    ->line("Vásárolt mennyiség: $product_quantity $product_unit")
                    ->line("Egységár a vásárlás során: $product_price")
                    ->line("Vásárló felhasználói neve: $user_name")
                    ->action("Termék megtekintése", route("product", $product_id))
                    ->line("Köszönjük, hogy a termékét a Rendszerünkön keresztül adta el!");
    }

    public function toArray(object $notifiable): array
    {
        // Szükséges adatok lekérdezése
        $product_quantity = $this->cart->quantity;
        $product_unit = $this->cart->product->unit->category->name;
        $product_price =  numformat_with_unit($this->cart->price,"Ft");
        
        // Üzenet szövegének összeállítása
        $body = "<ul><li>Vásárolt mennyiség: $product_quantity $product_unit</li>
        <li>Egységár a vásárlás során: $product_price</li></ul>";

        // Üzenet mentése
        return [
            'shop_id' => $this->shop->id,
            'shop_name' => $this->shop->name,
            'subject' => 'Sikeres vásárlás történt!',
            'body' => $body,
            'product_id' => $this->cart->product->id,
            'product_name' => $this->cart->product->name,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name
        ];
    }
}
