<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class MarketController extends Controller
{
    function market(){
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',$team)->get();
        $data = DB::table('ig_markets')->where('sesi','1')->get();
        $sesi = DB::table('sesi')->select('sesi')->get();
        return view('market',compact('data','user','sesi'));  
    }

    function marketBeli(Request $request){
        try {
            $item = $request->get('item');
            $total = $request->get('total');
            $team = $request->get('team');
            $total_bahan = $request->get('total_bahan');
            $sesi = $request->get('sesi');
            $totalItem = $request->get('totalItem');
            $sisaInv = 0;
    
            $team_detail = DB::table('teams')->select('dana','inventory')->where('idteam',$team)->get();
            if($team_detail[0]->inventory < $totalItem){
                return response()->json(array(
                    'msg'=>'maaf, sisa inventori mu tidak cukup untuk membeli bahan baku',
                    'code'=> '401'
                ), 401);
            }
            else{
               $sisaInv =  $team_detail[0]->inventory - $totalItem;
            }
            
            if($team_detail[0]->dana < $total){
                return response()->json(array(
                    'msg'=>'uang anda tidak cukup untuk membeli bahan baku',
                    'code'=> '401'
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
                        'msg'=>'maaf bahan baku yang ingin kamu beli sudah habis',
                        'code'=> '401'
                    ), 401);
                }
                else{
                    $sisaStok = $bahan_baku[$key]->stok - $val['quantity'];
                    $data = [
                        'ig_markets'    => $val['item'],
                        'quantity'      => $val['quantity'],
                        'subtotal'      => $val['subtotal']
                    ];
                    
                    DB::table('ig_markets')->where('idig_markets',$val['item'])->update([
                        'stok' => $sisaStok
                    ]);
                    
                    array_push($insert,$data);
                }
            }
            
            DB::table('invoice')->insert(['teams_idteam'=>$team, 'total_bahan'=> $total_bahan, 'total'=> $total, 'sesi'=> $sesi]);
            $idInvoice = DB::getPdo()->lastInsertId();
            foreach ($insert as $key => $val){
                $insert[$key]['invoice'] = $idInvoice;
            }
            
            DB::table('ig_markets_has_invoice')->insert($insert);
            $sisa_dana = $team_detail[0]->dana - $total;
            DB::table('teams')->where('idteam',$team)->update(['dana'=> $sisa_dana, 'inventory'=> $sisaInv]);
            
            $team_has_inventory = DB::table('inventory')->whereIn('ig_markets', $item_id)->where('teams',$team)->get();
            $insertStok = [];
            if(count($team_has_inventory)>0){
                foreach($team_has_inventory as $key => $val){
                    if($val->ig_markets == $item[$key]['item']){
                        $stok = $val->stock + $item[$key]['quantity'];
                        DB::table('inventory')->where('ig_markets',$item[$key]['item'])->where('teams',$team)->update([
                            'stock' => $stok
                        ]);
                        unset($item[$key]);
                    }
                }
            }
            if (count($item)>0){
                foreach($item as $key => $val){
                    $data = [
                        'ig_markets' => $val['item'],
                        'teams'      => $team,
                        'stock'      => $val['quantity']
                    ];
                    array_push($insertStok,$data);
                }
                DB::table('inventory')->insert($insertStok);
            }
            return response()->json(array(
                'msg'=>'selamat team anda berhasil membeli bahan baku',
                'code'=> '200'
            ), 200); 
        } catch (\PDOException $e) {
            return response()->json(array(
                'msg'=>'maaf ada kesalahan koneksi dengan server'.$e,
                'code'=> '401'
            ), 401);
        }

    }
}
