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
            $totalJual = 0;
            $countDemand = 0;

            foreach ($demand as $d){
                $produkDemand = DB::table('demand')->where('sesi',$sesi)->where('produk_idproduk',$d['produk'])->get();
                if(count($produkDemand)>0){
                    $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk',$d['produk'])->get();
                    $hargaJual = $d['total'] * $hargaProduk[0]->harga_jual;
                    DB::table('team_demand')->updateOrInsert(
                        ['idproduk'=>$d['produk'], 'idteam'=>$team, 'sesi'=>$sesi],
                        ['jumlah'=>$d['total']]
                    );
                    $totalJual += $hargaJual;
                    $countDemand +=1;
                }
            }

            if($countDemand> 0){
                $teamDana = DB::table('teams')->select('dana')->where('idteam', $team)->get();
                $danaBaru = $teamDana[0]->dana + $totalJual;
                DB::table('teams')->where('idteam', $team)->update(['dana'=>$danaBaru]);
    
                return response()->json(array(
                    'msg'=>'selamat team anda berhasil memenuhi demand',
                    'code'=> '200'
                ), 200); 
            }
            else {
                return response()->json(array(
                    'msg'=>'maaf team anda gagal memenuhi demand',
                    'code'=> '200'
                ), 200); 
            }

        } catch (\PDOException $e) {
            return response()->json(array(
                'msg'=>'maaf ada kesalahan koneksi dengan server'.$e,
                'code'=> '401'
            ), 401);
        }
       
    }
}
