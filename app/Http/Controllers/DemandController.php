<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DemandController extends Controller
{
    function demand()
    {
        $team = Auth::user()->teams_idteam;
        // $user = DB::table('teams')->select('nama', 'dana', 'idteam', 'inventory', 'demand', 'customer_value', 'hibah')->where('idteam', $team)->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();
        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        $user = DB::table('teams')->select('nama', 'idteam','dana')->where('idteam', $team)->get();
        $data = DB::table('team_demand')
            ->join('produk', 'team_demand.idproduk', 'produk.idproduk')
            ->where('idteam', $team)
            ->where('sesi', $getSesi[0]->nama)
            ->get();

        $produk = DB::table('produk')->select('idproduk', 'nama')->get();
        return view('demand', compact('data', 'produk', 'valueSesi', 'namaSesi', 'team', 'user'));
        // return view('demand',compact('produk','user','sesi1'));

    }

    function getDemand(Request $request)
    {
        $team = $request->get('team');
        $sesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi = $sesi[0]->nama;
        $list = DB::table('team_demand')
            ->join('produk', 'team_demand.idproduk', 'produk.idproduk')
            ->where('idteam', $team)
            ->where('sesi', $sesi)
            ->get();

        return response()->json(array(
            'list' => $list,
            'code' => '200'
        ), 200);
    }

    function konfrim(Request $request)
    {
        $this->authorize('isMarketing');
        try {
            $demand = $request->get('demand');
            $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
            $sesi = $getSesi[0]->nama;
            $team = Auth::user()->teams_idteam;
            $totalJual = 0;
            $countDemand = 0;
            $totalDemand = 0;
            $updtDemand = 0;

            //pengecean stok dan sisa demand
            foreach ($demand as $d) {
                $msg = '';
                $invtProduct = DB::table('history_produksi')->where('teams_idteam', $team)->where('produk_idproduk', $d['produk'])->get();
                $checkSisa = DB::table('team_demand')->where('idteam', $team)->where('idproduk', $d['produk'])->where('sisa', 0)->get();
                if (count($invtProduct) == 0 || $invtProduct[0]->hasil < $d['total']) {
                    $msg = 'maaf salah satu jumlah produk team kalian kurang untuk memenuhi demand';
                }
                if (count($checkSisa) > 0) $msg = 'maaf salah satu demand mu sudah mencapai batas terpenuhi';
                if ($msg != '') {
                    return response()->json(array(
                        'msg' => $msg,
                        'code' => '200'
                    ), 200);
                }
            }

            foreach ($demand as $d) {
                $sisa = 2;
                $produkDemand = DB::table('demand')->where('sesi', $sesi)->where('produk_idproduk', $d['produk'])->get();
                $invtProduct = DB::table('history_produksi')->where('teams_idteam', $team)->where('produk_idproduk', $d['produk'])->get();
                $usrDemand = DB::table('team_demand')->where('idproduk', $d['produk'])->where('idteam', $team)->where('sesi', $sesi)->get();

                //cek sisa
                if (count($usrDemand) > 0) {
                    if ($usrDemand[0]->sisa == 0) {
                        return response()->json(array(
                            'msg' => 'maaf team anda sudah memenuhi batas demand pada sesi ini',
                            'code' => '200'
                        ), 200);
                    } else if ($usrDemand[0]->sisa < 3) {
                        $sisa = $usrDemand[0]->sisa - 1;
                    }
                }


                if (count($produkDemand) > 0) {
                    $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk', $d['produk'])->get();
                    $hargaJual = $d['total'] * $hargaProduk[0]->harga_jual;
                    $totalJual += $hargaJual;
                    $countDemand += 1;
                    $totalDemand += $d['total'];
                    $updtDemand += $d['total'];
                }
                $sisaProduct = $invtProduct[0]->hasil - $d['total'];
                if (count($usrDemand) > 0) {
                    $updtDemand += $usrDemand[0]->jumlah;
                }
                DB::table('team_demand')->updateOrInsert(
                    ['idproduk' => $d['produk'], 'idteam' => $team, 'sesi' => $sesi],
                    ['jumlah' => $updtDemand, 'sisa' => $sisa]
                );
                DB::table('history_produksi')
                    ->where('teams_idteam', $team)
                    ->where('produk_idproduk', $d['produk'])
                    ->update([
                        'hasil' => $sisaProduct
                    ]);
            }

            if ($countDemand > 0) {
                $teamDana = DB::table('teams')->select('dana', 'demand', 'customer_value', 'hibah', 'total_pendapatan')->where('idteam', $team)->get();
                $danaBaru = $teamDana[0]->dana + $totalJual;
                $demandBaru = $teamDana[0]->demand + $totalDemand;
                $pendapatanBaru = $teamDana[0]->total_pendapatan + $totalJual;
                $customerValue = $pendapatanBaru;
                $hibah = floor($customerValue * 1.5);
                DB::table('teams')->where('idteam', $team)->update(['dana' => $danaBaru, 'demand' => $demandBaru, 'total_pendapatan' => $pendapatanBaru, 'customer_value' => $customerValue, 'hibah' => $hibah]);
                return response()->json(array(
                    'msg' => 'selamat team anda berhasil memenuhi demand',
                    'code' => '200'
                ), 200);
            } else {
                return response()->json(array(
                    'msg' => 'maaf team anda gagal memenuhi demand',
                    'code' => '200'
                ), 200);
            }
        } catch (\PDOException $e) {
            return response()->json(array(
                'msg' => 'maaf ada kesalahan koneksi dengan server' . $e,
                'code' => '401'
            ), 401);
        }
    }
}
