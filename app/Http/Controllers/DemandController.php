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
            $totalDemand = 0;

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
                }
                $sisaProduct = $invtProduct[0]->hasil - $d['total'];
                DB::table('team_demand')->updateOrInsert(
                    ['idproduk'=>$d['produk'], 'idteam'=>$team, 'sesi'=>$sesi],
                    ['jumlah'=>$d['total']]
                );
                DB::table('history_produksi')
                    ->where('teams_idteam',$team)
                    ->where('produk_idproduk',$d['produk'])
                    ->update([
                        'hasil' => $sisaProduct
                    ]);
            }

            if($countDemand> 0){
                $teamDana = DB::table('teams')->select('dana','demand','customer_value','hibah','total_pendapat')->where('idteam', $team)->get();
                $danaBaru = $teamDana[0]->dana + $totalJual;
                $demandBaru = $teamDana[0]->demand + $totalDemand;
                $pendapatanBaru = $teamDana[0]->total_pendapat + $totalJual;
                $customerValue = $pendapatanBaru*$demandBaru;
                $hibah = $customerValue/100;
                DB::table('teams')->where('idteam', $team)->update(['dana'=>$danaBaru,'demand'=>$demandBaru,'total_pendapat'=>$pendapatanBaru,'customer_value'=> $customerValue,'hibah'=> $hibah]);
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
