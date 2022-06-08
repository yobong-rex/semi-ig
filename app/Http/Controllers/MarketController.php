<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MarketController extends Controller
{
    function market(){
        $data = DB::table('ig_markets')->where('sesi','1')->get();
        return view('market',compact('data'));  
    }
}
