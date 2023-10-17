<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

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

        // Oldal meghívása
        return view('admin.index');
    }

    // Tevékenység napló
    public function log()
    {

        // Naplóbejegyzések betöltése
        $logs = Activity::orderBy('created_at','desc')->get();

        // Végigmenni minden egyes bejegyzésen
        foreach ($logs AS $log) {

            // Lekérdezni a létrehozó felhasználó nevét
            $log->causer_name = (User::find($log->causer_id)) ? User::find($log->causer_id)->name : null; 
        }

        // Oldal meghívása
        return view('admin.log', [
            'logs' => $logs
        ]);
    }
    
}
