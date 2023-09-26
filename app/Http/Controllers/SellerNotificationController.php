<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerNotificationController extends Controller
{
    
    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Értesítések
    public function index()
    {
        return view('seller.notification');
    }
}
