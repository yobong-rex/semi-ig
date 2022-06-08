<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AnalisisController extends Controller
{
    function insert(Request $Request){
        $produksi = $Request('produksi');
        $length = $Request('length');
        DB::table('analisis')->insert([
            'produksi' => $produksi,
            'length' => $length
        ]);
    }
}
