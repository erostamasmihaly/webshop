<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    { }

    // Fő oldal
    public function index()
    {
        return view('home');
    }

}
