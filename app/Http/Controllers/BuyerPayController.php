<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentFinish;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\PaymentShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class BuyerPayController extends Controller
{
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Megerősítés oldal megjelenítése
    public function confirm()
    {

        // Felhasználó adatainak lekérdezése
        $user = User::where('id', Auth::id())->first();

        // Oldal meghívása
        return view('buyer.pay_confirm', [
            'carts' => get_cart()['carts'],
            'total_ft' => get_cart()['total_ft'],
            'user' => $user
        ]);

    }

    // Adattovábbítási nyilatkozat
    public function statement() {
        
        // Oldal meghívása
        return view('buyer.pay_statement');
    }

    // Fizetés elindítása
    public function start()
    {

        // Adatok importálása
        $path = base_path();
        require_once $path.'/simplepay/config.php';
        require_once $path.'/simplepay/SimplePayV21.php';

        // Új fizetési tranzakció létrehozása
        $trx = new \SimplePayStart();
        $trx->addConfig($config);

        // Fizetés létrehozása
        $order_ref = generate_order_ref();

        // Elemek tömbje
        $items = [];
        $i = 0;

        // Kosár lekérdezése
        $carts = get_cart()["carts"];

        // Kosár elemeinek behelyezése ebbe a tömbbe
        foreach ($carts AS $cart) {
            $quantity = cart_quantity_split(Cart::find($cart->id));
            $items[$i]['ref'] = $cart->id;
            if ($cart->size_name!="") {
                $items[$i]['title'] = $cart->product_name." (".$cart->size_name.")";    
            } else {
                $items[$i]['title'] = $cart->product_name;
            }
            $items[$i]['amount'] = $quantity;
            $items[$i]['price'] = $cart->discount_price;
            $i++;
        }

        // Termék adatai
        $trx->addData('items', $items);
        $trx->addData('orderRef', $order_ref);

        // Felhasználó adatai
        $user = User::where('id', Auth::id())->first();

        // Vevő adatai - Banknak elküldött adatok
        $trx->addGroupData('invoice', 'name', $user->surname." ".$user->forename);
        $trx->addGroupData('invoice', 'country', $user->country);
        $trx->addGroupData('invoice', 'state', $user->state);
        $trx->addGroupData('invoice', 'city', $user->city);
        $trx->addGroupData('invoice', 'zip', $user->zip);
        $trx->addGroupData('invoice', 'address', $user->address);
        $trx->addData('customerEmail', $user->email);

        // Állandó adatok
        $trx->addData('currency', 'HUF');
        $trx->addData('threeDSReqAuthMethod', '02');
        $trx->addData('language', 'HU');
        $timeoutInSec = 60;
        $timeout = @date('c', time() + $timeoutInSec);
        $trx->addData('timeout', $timeout);
        $trx->addData('methods', array('CARD'));
        $trx->addData('url', $config['URL']);

        // Tranzakció elindítása
        $trx->runStart();
        $tbase = $trx->getTransactionBase();

        // Fizetés létrehozása
        $payment = new Payment();
        $payment->user_id = Auth::id();
        $payment->order_ref = $tbase["orderRef"];
        $payment->items = json_encode($tbase["items"]);
        $payment->invoice = json_encode($tbase["invoice"]);

        // Válasz
        $returnData = $trx->getReturnData();

        // Fizetett összeg elmentése
        $payment->total = $returnData['total'];

        // Történt-e valami hiba a művelet során
        if (isset($returnData['errorCodes'])) {

            //// Ha hiba történt
            // Visszaegyesíteni a kosarakat, ha kell
            foreach ($carts AS $cart) {
                cart_quantity_join(Cart::find($cart->id));
            }

            // Fizetésnél felvinni, hogy hiba volt és mellékelni a hibakódokat
            $payment->error = json_encode($returnData['errorCodes']);
            $payment->save();

            // Hiba oldal megnyitása
            return redirect()->route('pay_transaction_failed')->with(['payment_id' => $payment->id]);

        } else {

            //// Ha sikeres volt
            // Fizetésnél felvinni, hogy sikeres volt és mellékelni a tranzakció azonosítót
            $payment->transaction_id = $returnData['transactionId'];
            $payment->save();

            // Fizetéshez tartozó URL elmentése
            $url = $returnData['paymentUrl'];

            // Fizetés előtti oldal betöltése
            return redirect()->route('pay_transaction_success')->with(['payment_id' => $payment->id, 'url' => $url]);

        }

    }

    // Sikertelen tranzakció
    public function transaction_failed() {

        // Fizetési azonosító lekérdezése
        $payment_id = Session::get('payment_id');

        // Hibakód lekérdezése
        $error = Payment::find($payment_id)->error;

        // Felület megnyitása
        return view('buyer.pay_transaction_failed', [
            'error' => $error
        ]);
    }

    // Sikeres tranzakció
    public function transaction_success() {

        // URL lekérdezése
        $url = Session::get('url');

        // Felület megnyitása
        return view('buyer.pay_transaction_success', [
            'url' => $url
        ]);
    }

    // Visszatérés a fizetés után
    public function back() {

        // Adatok importálása
        $path = base_path();
        require_once $path.'/simplepay/config.php';
        require_once $path.'/simplepay/SimplePayV21.php';

        // Fizetési tranzakció eredményének eltárolása
        $trx = new \SimplePayBack;
        $trx->addConfig($config);

        // Eredmény lekérdezése
        $result = array();
        if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
            if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
                $result = $trx->getRawNotification();
            }
        }

        // Fizetés kikeresése
        $payment = Payment::where('order_ref',$result['o'])->get()->first();

        // Fizetés frissítése az eredménnyel
        $payment->result = $result['e'];

        if ($result['e']=='SUCCESS') {

            // Fizetés mentése
            $payment->finished = 1;
            $payment->save();

            // Elemek lekérdezése
            $items = json_decode($payment->items);

            // Kérés létrehozása
            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'items' => $items,
                'payment_id' => $payment->id
            ]);

            // Fizetés befejezése ezen elemekkel
            new PaymentFinish($request);

            // Értesítés kiküldése
            $this->notifications($payment->id);

            // Átirányítás a Vásárlási előzményekhez az üzenettel
            return redirect()->route('pay_history')->withMessage('Sikeres vásárlás! SimplePay tranzakció azonosító: '.$payment->transaction_id);

        } else {

            // Fizetés mentése
            $payment->save();

            // Hiba ok bővebb megfogalmazása
            switch ($payment->result) {
                case "FAIL":
                    $result = "Sikertelen fizetés!";
                    break;
                case "CANCEL":
                    $result = "Felhasználó által visszavonva!";
                    break;
                case "TIMEOUT":
                    $result = "Időtúllépés miatt a fizetés megszakítva!";
                    break;
            }

            // Kosár lekérdezése
            $carts = get_cart()["carts"];

            // Visszaegyesíteni a kosarakat, ha kell
            foreach ($carts AS $cart) {
                cart_quantity_join(Cart::find($cart->id));
            }

            // Visszatérés a kosárba a hibával
            return redirect()->route('buyer_cart')->withErrors($result);
        }
    }

    // Vásárlási előzmények oldal
    public function history() {

        // Oldal meghívása
        return view('buyer.pay_history',[
            'elements' => get_pay_history()
        ]);
    }

    // Értesítések kiküldése
    public function notifications($id) {

        // Fizetéshez tartozó kosár bejegyzések lekérdezése
        $carts = Payment::find($id)->carts;

        // Végigmenni minden ilyen bejegyzésen
        foreach ($carts AS $cart) {

            // Kérés létrehozása az értesítéshez
            $notification_request = new Request();
            $notification_request->setMethod('POST');
            $notification_request->request->add([
                'shop' => $cart->product->shop,
                'user' => $cart->user,
                'cart' => $cart
            ]);

            // Üzlet e-mail címének és nevének lekérdezése
            $shop = [
                $cart->product->shop->email => $cart->product->shop->name
            ];

            // Értesítés beállítása
            $payment_shop = new PaymentShop($notification_request);

            // E-mail értesítés küldése az üzletnek
            Notification::route('mail', $shop)->notify($payment_shop);

            // Üzlet összes alkalmazottjának lekérdezése
            $users = Shop::find($cart->product->shop->id)->users();

            // Adatbázis értesítés küldése minden alkalmazottnak
            if ($users->count() > 0) {
                Notification::send($users, $payment_shop);
            }

        }
    }
}
