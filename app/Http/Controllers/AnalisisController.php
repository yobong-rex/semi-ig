<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AnalisisController extends Controller
{
    function analisi(){
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        $sesi = DB::table('sesi')->select('sesi')->get();
        // $cycleTime = DB::
    }

    function insertProses(Request $request){
        $produksi = $request->get('produksi');
        $length = $request->get('panjang');
        $proses = $request->get('proses');
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        DB::table('analisis')->insert([
            'produksi' => $produksi,
            'length' => $length
        ]);
        // buat dapetin id terakhir yang diinsert
        $idanalisis = DB::getPdo()->lastInsertId();
        DB::table('teams_has_analisis')->insert([
            'teams_idteam' => $user[0]->idteam,
            'analisis_idanalisis'=> $idanalisis,
            'proses'=> $proses
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
