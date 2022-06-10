<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AnalisisController extends Controller
{
    function insert(Request $request){
        $produksi = $request('produksi');
        $length = $request('length');
        DB::table('analisis')->insert([
            'produksi' => $produksi,
            'length' => $length
        ]);
    }

    function admin(){
        $data = DB::table('sesi')->select('analisis')->get();
        return view('Analisis_Bahan_Baku.admin',compact('data')); 
    }

    function updateSesi(Request $request){
        $status = $request->get('status');
        DB::table('sesi')->where('idsesi',1)->update(['analisis' => $status]);
        return redirect()->route('analisis.admin')->with('status','status sesi analisis berhasil diubah');
    }
}
