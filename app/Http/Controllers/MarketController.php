<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Events\Market;
use Illuminate\Http\Response;

class MarketController extends Controller
{
    function market()
    {
        $user = DB::table('teams')->select('nama', 'idteam')->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();
        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        $data = DB::table('ig_markets')->where('sesi', $getSesi[0]->nama)->get();
        return view('market', compact('data', 'user', 'valueSesi', 'namaSesi'));
    }

    function marketBeli(Request $request)
    {
        $this->authorize('isAdmin');
        try {
            $item = $request->get('item');
            $total = $request->get('total');
            $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
            $sesi = $getSesi[0]->nama;
            $team = $request->get('team');
            $total_bahan = $request->get('total_bahan');
            $totalItem = $request->get('totalItem');
            $sisaInv = 0;

            if ($team == "") {
                return response()->json(array(
                    'msg' => 'tolong pilih team terlebih dahulu',
                    'code' => '401'
                ), 200);
            }

            $team_detail = DB::table('teams')->select('dana', 'inventory')->where('idteam', $team)->get();
            if ($team_detail[0]->inventory < $totalItem) {
                return response()->json(array(
                    'msg' => 'maaf, sisa inventori mu tidak cukup untuk membeli bahan baku',
                    'code' => '401'
                ), 200);
            } else {
                $sisaInv =  $team_detail[0]->inventory - $totalItem;
            }

            if ($team_detail[0]->dana < $total) {
                return response()->json(array(
                    'msg' => 'uang anda tidak cukup untuk membeli bahan baku',
                    'code' => '401'
                ), 200);
            }

            $item_id = [];
            foreach ($item as $i) {
                array_push($item_id, $i['item']);
            }

            $bahan_baku = DB::table('ig_markets')->whereIn('idig_markets', $item_id)->get();
            $insert = [];
            $stokPusser = array();
            foreach ($item as $key => $val) {
                if ($bahan_baku[$key]->stok < $val['quantity']) {
                    return response()->json(array(
                        'msg' => 'maaf bahan baku yang ingin kamu beli sudah habis',
                        'code' => '401'
                    ), 200);
                } else {
                    $sisaStok = $bahan_baku[$key]->stok - $val['quantity'];
                    $data = [
                        'ig_markets'    => $val['item'],
                        'quantity'      => $val['quantity'],
                        'subtotal'      => $val['subtotal']
                    ];

                    DB::table('ig_markets')->where('idig_markets', $val['item'])->update([
                        'stok' => $sisaStok
                    ]);
                    $temp['idItem'] = $val['item'];
                    $temp['stock'] = $sisaStok;

                    array_push($insert, $data);
                    array_push($stokPusser, $temp);
                }
            }

            DB::table('invoice')->insert(['teams_idteam' => $team, 'total_bahan' => $total_bahan, 'total' => $total, 'sesi' => $sesi]);
            $idInvoice = DB::getPdo()->lastInsertId();
            foreach ($insert as $key => $val) {
                $insert[$key]['invoice'] = $idInvoice;
            }

            DB::table('ig_markets_has_invoice')->insert($insert);
            $sisa_dana = $team_detail[0]->dana - $total;
            DB::table('teams')->where('idteam', $team)->update(['dana' => $sisa_dana, 'inventory' => $sisaInv]);

            $team_has_inventory = DB::table('inventory')->whereIn('ig_markets', $item_id)->where('teams', $team)->get();
            // $insertStok = [];
            foreach ($item as $key => $val) {
                // $stok = ($item[$key]['quantity'] * $item[$key]['isi']);
                $stok = ($val['quantity'] * $val['isi']);
                if (count($team_has_inventory) > 0) {
                    foreach ($team_has_inventory as $key2 => $val2) {
                        if ($val2->ig_markets == $val['item']) {
                            $stok += $val2->stock;
                            // DB::table('inventory')->where('ig_markets',$item[$key]['item'])->where('teams',$team)->update([
                            //     'stock' => $stok
                            // ]);
                            // unset($item[$key]);
                        }
                    }
                }
                $getInventory = DB::table('inventory')->where('teams', $team)->where('ig_markets', $val['nama'])->get();
                $newInventory = $stok;
                if(count($getInventory)>0){
                    $newInventory = $getInventory[0]->stock + $stok;
                }
                DB::table('inventory')->updateOrInsert(
                    ['ig_markets' => $val['nama'], 'teams' => $team],
                    ['stock' => $newInventory]
                );
                event(new Market($stokPusser));
            }

            return response()->json(array(
                "success" => true,
                'msg' => 'selamat team anda berhasil membeli bahan baku',
                'code' => '200'
            ), 200);
        } catch (\PDOException $e) {

            return response()->json(array(
                'msg' => 'maaf ada kesalahan koneksi dengan server  ' . $e,
                'code' => '401'
            ), 200);
        }
    }
}
