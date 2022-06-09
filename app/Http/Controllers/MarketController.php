<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MarketController extends Controller
{
    function market(){
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        $data = DB::table('ig_markets')->where('sesi','1')->get();
        return view('market',compact('data','user'));  
    }

    function marketBeli(Request $request){
        try {
            $item = $request->get('item');
            $total = $request->get('total');
            $team = $request->get('team');
            $total_bahan = $request->get('total_bahan');
    
            $team_detail = DB::table('teams')->select('dana')->where('idteam',$team)->get();
    
            if($team_detail[0]->dana < $total){
                return response()->json(array(
                    'msg'=>'uang anda tidak cukup untuk membeli bahan baku'
                ), 401);
            }
    
            $item_id = [];
            foreach ($item as $i){
                array_push($item_id, $i['item']);
            }   
    
            $bahan_baku = DB::table('ig_markets')->whereIn('idig_markets', $item_id)->get();
            $insert = [];
            foreach ($item as $key => $val){
                if($bahan_baku[$key]->stok<$val['quantity']){
                    return response()->json(array(
                        'msg'=>'maaf bahan baku yang ingin kamu beli sudah habis'
                    ), 401);
                }
                else{
                    $data = [
                        'ig_markets'    => $val['item'],
                        'quantity'      => $val['quantity'],
                        'subtotal'      => $val['subtotal']
                    ];
                    array_push($insert,$data);
                }
            }
            // DB::table('invoice')->insert(['teams_idteam'=>$team, 'total_bahan'=> $total_bahan, 'total'=> $total, 'sesi'=> '1']);
            // $idInvoice = DB::getPdo()->lastInsertId();
            // foreach ($insert as $key => $val){
            //     $insert[$key]['invoice'] = $idInvoice;
            // }
            
            // DB::table('ig_markets_has_invoice')->insert($insert);
            // $sisa_dana = $team_detail[0]->dana - $total;
            // DB::table('teams')->where('idteam',$team)->update(['dana'=> $sisa_dana]);
            return response()->json(array(
                'msg'=>'selamat team anda berhasil membeli bahan baku'
            ), 200); 
        } catch (\PDOException $e) {
            return response()->json(array(
                'msg'=>'maaf ada kesalahan koneksi dengan server'
            ), 401);
        }

    }
}
