<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $order_ref = str_replace(array('.', ':', '/'), '', @$_SERVER['SERVER_ADDR']) . @date('U', time()) . rand(1000, 9999);

        // Elemek tömbje
        $items = [];
        $i = 0;

        // Kosár lekérdezése
        $carts = get_cart()["carts"];

        // Kosár elemeinek behelyezése ebbe a tömbbe
        foreach ($carts as $cart) {
            $items[$i]['ref'] = $cart->id;
            $items[$i]['title'] = $cart->name;
            $items[$i]['amount'] = $cart->quantity;
            $items[$i]['price'] = $cart->discount_price;
            $i++;
        }

        // Termék adatai
        $trx->addData('items', $items);
        //$trx->addData('orderRef', $order_ref);

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
            return redirect()->route('pay_transaction_success');

        }

    }

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

    public function transaction_success($payment_id, $url) {
        dd($payment_id, $url);
    }

    public function back() {

    }
}
