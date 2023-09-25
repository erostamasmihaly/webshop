<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index() {

        $controller = new BuyerProtectedController();
        $controller->favourite_notification(1);
    }
}
