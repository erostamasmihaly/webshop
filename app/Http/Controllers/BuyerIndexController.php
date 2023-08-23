<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerIndexController extends Controller
{

    public function __construct()
    { }

    // Fő oldal
    public function index()
    {
        return view('buyer.index');
    }

}
