<?php

namespace App\Http\Controllers;

class SellerIndexController extends Controller
{

    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Alkalmazottak főoldal
    public function index()
    {
        return view('seller.index');
    }
    
}