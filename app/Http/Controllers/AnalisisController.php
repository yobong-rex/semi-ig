<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AnalisisController extends Controller
{
    function analisi(){
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        $sesi = DB::table('sesi')->select('sesi')->get();
        $mesin = DB::table('mesin')
            ->join('view_kapasitas_mesin','mesin.idmesin','=','view_kapasitas_mesin.mesin_id')
            ->join('mesin_has_teams','mesin.idmesin','=','mesin_has_teams.mesin_idmesin')
            ->select('mesin.idmesin','mesin.nama','mesin.cycle','view_kapasitas_mesin.kapasitas')
            ->where('mesin_has_teams.teams_idteam',1)
            ->where('view_kapasitas_mesin.team',1)
            ->get();
        
        return view('Sesi_Analisis.analisis',compact('mesin','user','sesi')); 
    }

    function insertProses(Request $request){
        $produksi = $request->get('produksi');
        $length = $request->get('panjang');
        $proses = $request->get('proses');
        $kapasitas = $request->get('kapasitas');
        $cycle = $request->get('cycle');

        //mencari kapasitas terkecil
        $minKpasitas = min($kapasitas);

        //mencari cycletime
        $time = array_sum($cycle);
        $cycleTime = intval($time/25);

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
            'proses'=> $proses,
            'maxProduct'    => $minKpasitas,
            'cycleTime'     => $cycleTime
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
