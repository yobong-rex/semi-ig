<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DemandController extends Controller
{
    function demand(){
        $sesi = DB::table('sesi')->select('sesi')->get();
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        $data = DB::table('team_demand')
                    ->join('produk','team_demand.idproduk','produk.idproduk')
                    ->where('idteam',1)
                    ->where('sesi',$sesi[0]->sesi)
                    ->get();
        $produk = DB::table('produk')->select('idproduk','nama')->get();

        return view('demand',compact('data','produk','user','sesi'));  
        
    }

    function konfrim(Request $request){
        try {
            $demand = $request->get('demand');
            $team = $request->get('team');
            $sesi = $request->get('sesi');

            $produk_id = [];
            foreach ($demand as $d){
                array_push($produk_id, $d['produk']);
            }

            

        } catch (\PDOException $e) {
            return response()->json(array(
                'msg'=>'maaf ada kesalahan koneksi dengan server'.$e,
                'code'=> '401'
            ), 401);
        }
       
    }
}
