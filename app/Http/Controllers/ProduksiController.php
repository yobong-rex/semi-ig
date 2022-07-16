<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProduksiController extends Controller
{

    function getDefect($proses, $user)
    {
        $defect = '';
        $tempDefect = [];
        $defectDefault = 10;
        foreach ($proses as $p) {
            $data = DB::table('mesin as m')
                ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
                ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
                ->select('k.level')
                ->where('lk.teams_idteam', $user[0]->idteam)
                ->where('m.nama', $p)
                ->orderBy('k.idkomponen', 'asc')
                ->get();
            if (count($data) > 0) {
                foreach ($data as $d) {
                    $lvlDefect = $d->level - 1;
                    array_push($tempDefect, $lvlDefect);
                }
                $minDefect = min($tempDefect);
                $newDefect = $defectDefault - $minDefect;
                $defect = $defect . $newDefect . ';';
            }
        }
        return $defect;
    }

    function produksi()
    {
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
        $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi1 = $getSesi[0]->nama;
        // $sesi1 = $sesi[0]->sesi;
        if ($sesi1 == 3) {
            return redirect()->route('dashboard');
        }
        $proses1 = '';
        $proses2 = '';
        $proses3 = '';
        if ($sesi1 == 1) {
            $proses1 = 'Sorting;Cutting;Bending;Assembling;Delay;Cutting;Assembling;Sorting;Packing';
            $proses2 = 'Sorting;Cutting;Assembling;Drilling;Delay;Cutting;Assembling;Idle;Packing';
            $proses3 = 'Sorting;Molding;Idle;Assembling;Sorting;Delay;Assembling;Packing;';
        } else {
            $proses1 = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 1)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses2 = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 2)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses3 = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 3)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            if(count($proses1) == 0 || count($proses2) == 0 || count($proses3) == 0){
                return redirect()->route('analisis')->with('error','tolong isi terlebih dahulu proses produksi 1,2,dan 3');
            }
            $proses1 = $proses1[0]->proses;
            $proses2 = $proses2[0]->proses;
            $proses3 = $proses3[0]->proses;
        }

        $splitProses1 = explode(';', $proses1);
        $splitProses2 = explode(';', $proses2);
        $splitProses3 = explode(';', $proses3);

        $defect1 = $this->getDefect($splitProses1, $user);
        $defect2 = $this->getDefect($splitProses2, $user);
        $defect3 = $this->getDefect($splitProses3, $user);
        
        return view('Produksi.produksi', compact('splitProses1', 'splitProses2', 'splitProses3', 'defect1', 'defect2', 'defect3', 'user', 'sesi'));
    }

    function buat(Request $request)
    {
        $this->authorize('isProduction_Manager');
        $btn = $request->get('btn');
        $produk = $request->get('produk');
        $jumlah = $request->get('jumlah');
        $defect = $request->get('defect');
        $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi = $getSesi[0]->nama;
        $team = Auth::user()->teams_idteam;
        $name = $request->get('name');

        if($produk == ''){
            return response()->json(array(
                'msg' => 'maaf, tolong pilih produk yang ingin diproduksi terlebih dahulu',
                'code' => '401'
            ), 200);
        }

        if ($sesi == 1) {
            if ($jumlah > 80) {
                return response()->json(array(
                    'msg' => 'maaf, jumlah yang ingin kamu produksi melebihi kapasitas produksi',
                    'code' => '401'
                ), 200);
            }
        } else {

            $idanalisisProses = DB::table('analisis as a')
                ->join('teams_has_analisis as tha', 'a.idanalisis', '=', 'tha.analisis_idanalisis')
                ->select(DB::raw('MAX(a.idanalisis) as maxIdAnalisis'))
                ->where('tha.teams_idteam', $team)
                ->where('a.produksi', $btn)
                ->groupBy('a.produksi')
                ->orderBy('a.idanalisis')
                ->get();

            $analisisProses = [];
            foreach ($idanalisisProses as $idAP) {
                $arrAP = DB::table('teams_has_analisis')
                    ->select('maxProduct', 'cycleTime')
                    ->where('analisis_idanalisis', $idAP->maxIdAnalisis)
                    ->get();
                $analisisProses[] = array($arrAP[0]->maxProduct, $arrAP[0]->cycleTime);
            }

            if (($jumlah > $analisisProses[0][0]) || ($jumlah > $analisisProses[0][1])) {
                return response()->json(array(
                    'msg' => 'maaf, jumlah yang ingin kamu produksi melebihi kapasitas produksi',
                    'code' => '401'
                ), 200);
            }
        }

        $bahanBaku = DB::table('produk')->select('bahan_baku')->where('idproduk', $produk)->get();
        $bahanBaku_split = explode(';', $bahanBaku[0]->bahan_baku);
        $teamStatus = DB::table('teams')->select('dana', 'inventory')->where('idteam', $team)->get();
        if ($teamStatus[0]->dana < 100) {
            return response()->json(array(
                'msg' => 'maaf, maaf dana mu kurang untuk membuat product',
                'code' => '401'
            ), 200);
        }

        foreach ($bahanBaku_split as $bb) {
            $inv = DB::table('inventory')
                ->join('ig_markets', 'inventory.ig_markets', '=', 'ig_markets.idig_markets')
                ->select('inventory.stock', 'ig_markets.idig_markets', 'ig_markets.isi')
                ->where('inventory.teams', $team)
                ->where('ig_markets.bahan_baku', 'like', "%" . $bb . "%")
                ->where('ig_markets.sesi', $sesi)
                ->get();
            if (count($inv) > 0) {
                if ($jumlah > $inv[0]->stock) {
                    return response()->json(array(
                        'msg' => 'maaf, bahan baku mu kurang untuk membuat product',
                        'code' => '401'
                    ), 200);
                } else {
                    $invBaru = $inv[0]->stock - $jumlah;
                    DB::table('inventory')
                        ->where('ig_markets', $inv[0]->idig_markets)
                        ->where('teams', $team)
                        ->update(['stock' => $invBaru]);
                }
            } else {
                return response()->json(array(
                    'msg' => 'maaf, bahan baku mu kurang untuk membuat product',
                    'code' => '401'
                ), 200);
            }
        }

        //bagian penghitungan jml produk jadi
        $jmlTemp = $jumlah;
        $defect_split = explode(';', $defect);

        foreach (array_keys($defect_split, '', true) as $key) {
            unset($defect_split[$key]);
        }
        foreach ($defect_split as $d) {
            $persen = 100 - (int)$d;
            $jmlTemp = $jmlTemp * $persen / 100;
        }
        $hasil = floor($jmlTemp);
        $hasil_user = $hasil;
        $histori = DB::table('history_produksi')->select('hasil')->where('teams_idteam', $team)->where('produk_idproduk', $produk)->get();
        if (count($histori) > 0) {
            $hasil += $histori[0]->hasil;
        }
        $totBahan = $jumlah * 3;
        $newInv = $teamStatus[0]->inventory + $totBahan;
        $newDana = $teamStatus[0]->dana - 100;
        DB::table('history_produksi')
            ->updateOrInsert(
                ['teams_idteam' => $team, 'produk_idproduk' => $produk,'sesi'=> $sesi],
                ['hasil' => $hasil]
            );
        DB::table('teams')->where('idteam', $team)->update([
            'dana'          => $newDana,
            'inventory'     => $newInv
        ]);
        return response()->json(array(
            'msg' => 'selamat kamu berhasil melakukan produksi '.$name.' sebanyak '. $hasil_user,
            'code' => '401'
        ), 200);
    }
}
