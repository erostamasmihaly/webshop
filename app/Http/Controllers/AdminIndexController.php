<?php

namespace App\Http\Controllers;

class AdminIndexController extends Controller
{

    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Admin főoldal
    public function index()
    {
        return view('admin.index');
    }
    
}
