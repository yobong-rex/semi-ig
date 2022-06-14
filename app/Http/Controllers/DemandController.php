<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DemandController extends Controller
{
    function demand(){
        $sesi = DB::table('sesi')->select('sesi')->get();
        $user = DB::table('teams')->select('nama','idteam')->get();
        // $data = DB::table('team_demand')
        //             ->join('produk','team_demand.idproduk','produk.idproduk')
        //             ->where('idteam',1)
        //             ->where('sesi',$sesi[0]->sesi)
        //             ->get();
        $produk = DB::table('produk')->select('idproduk','nama')->get();
        $sesi1 = $sesi[0]->sesi;
        // return view('demand',compact('data','produk','user','sesi1'));  
        return view('demand',compact('produk','user','sesi1'));  
        
    }

    function getDemand(Request $request){
        $team = $request->get('team');
        $sesi = $request->get('sesi');

        $list = DB::table('team_demand')
                    ->join('produk','team_demand.idproduk','produk.idproduk')
                    ->where('idteam',$team)
                    ->where('sesi',$sesi)
                    ->get();
        
        return response()->json(array(
            'list'=>$list,
            'code'=> '200'
        ), 200); 
    }

    function konfrim(Request $request){
        try {
            $demand = $request->get('demand');
            $team = $request->get('team');
            $sesi = $request->get('sesi');
            $totalJual = 0;
            $countDemand = 0;
            $totalDemand = 0;
            $updtDemand = 0;


            //pengecean stok
            foreach ($demand as $d){
                $invtProduct = DB::table('history_produksi')->where('teams_idteam',$team)->where('produk_idproduk',$d['produk'])->get();
                if( count($invtProduct)==0 || $invtProduct[0]->hasil < $d['total']){
                    return response()->json(array(
                        'msg'=>'maaf salah satu jumlah produk team kalian kurang untuk memenuhi demand',
                        'code'=> '200'
                    ), 200); 
                }
            }

            foreach ($demand as $d){
                $produkDemand = DB::table('demand')->where('sesi',$sesi)->where('produk_idproduk',$d['produk'])->get();
                $invtProduct = DB::table('history_produksi')->where('teams_idteam',$team)->where('produk_idproduk',$d['produk'])->get();
                if(count($produkDemand)>0){
                    $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk',$d['produk'])->get();
                    $hargaJual = $d['total'] * $hargaProduk[0]->harga_jual;
                    $totalJual += $hargaJual;
                    $countDemand +=1;
                    $totalDemand += $d['total'];
                    $updtDemand += $d['total'];
                }
                $sisaProduct = $invtProduct[0]->hasil - $d['total'];
                $usrDemand = DB::table('team_demand')->where('idproduk',$d['produk'])->where('idteam',$team)->where('sesi',$sesi)->get();
                if(count($usrDemand)>0){
                    $updtDemand += $usrDemand[0]->jumlah;
                }
                DB::table('team_demand')->updateOrInsert(
                    ['idproduk'=>$d['produk'], 'idteam'=>$team, 'sesi'=>$sesi],
                    ['jumlah'=>$updtDemand]
                );
                DB::table('history_produksi')
                    ->where('teams_idteam',$team)
                    ->where('produk_idproduk',$d['produk'])
                    ->update([
                        'hasil' => $sisaProduct
                    ]);
            }

            if($countDemand> 0){
                $teamDana = DB::table('teams')->select('dana','demand','customer_value','hibah','total_pendapatan')->where('idteam', $team)->get();
                $danaBaru = $teamDana[0]->dana + $totalJual;
                $demandBaru = $teamDana[0]->demand + $totalDemand;
                $pendapatanBaru = $teamDana[0]->total_pendapatan + $totalJual;
                $customerValue = $pendapatanBaru*$demandBaru;
                $hibah = $customerValue/100;
                DB::table('teams')->where('idteam', $team)->update(['dana'=>$danaBaru,'demand'=>$demandBaru,'total_pendapatan'=>$pendapatanBaru,'customer_value'=> $customerValue,'hibah'=> $hibah]);
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
                'msg'=>'maaf ada kesalahan koneksi dengan server',
                'code'=> '401'
            ), 401);
        }
       
    }
}
