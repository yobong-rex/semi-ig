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
            if($p != 'Idle' || $p != 'Delay'){
                $data = DB::table('mesin_has_teams')
                    ->join('mesin', 'mesin_has_teams.mesin_idmesin', '=','mesin.idmesin')
                    ->select('mesin_has_teams.level')
                    ->where('mesin.nama', $p)
                    ->where('mesin_has_teams.teams_idteam', $user[0]->idteam)
                    ->get();
                    if (count($data) > 0) {
                            // $lvlDefect = $d->level - 1;
                            // array_push($tempDefect, $lvlDefect);
                            $minDefect = 0;
                            if($data[0]->level == 2){
                                $minDefect = 2;
                            }
                            else if($data[0]->level == 3){
                                $minDefect = 4;
                            }
                            else if($data[0]->level == 4){
                                $minDefect = 6;
                            }
                            else if($data[0]->level == 5){
                                $minDefect = 8;
                            }
                            else if($data[0]->level == 6){
                                $minDefect = 10;
                            }
                            $newDefect = $defectDefault - $minDefect;
                            $defect = $defect . $newDefect . ';';
                        }
            }
            //     ->get();
            // $data = DB::table('mesin as m')
            //     ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            //     ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            //     ->select('k.level')
            //     ->where('lk.teams_idteam', $user[0]->idteam)
            //     ->where('m.nama', $p)
            //     ->orderBy('k.idkomponen', 'asc')
            //     ->get();
                // $minDefect = min($tempDefect);
        }
        return $defect;
    }

    function produksi()
    {
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
        $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi1 = $getSesi[0]->nama;

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();

        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        if ($namaSesi == 2) {
            return redirect()->route('dashboard');
        }

        $proses1 = '';
        $proses2 = '';
        $proses3 = '';

        if ($namaSesi == 1) {
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

            if (count($proses1) == 0 || count($proses2) == 0 || count($proses3) == 0) {
                return redirect()->route('analisis')->with('error', 'tolong isi terlebih dahulu proses produksi 1,2,dan 3');
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

        $limit = DB::table('teams')->select('limit_produksi1','limit_produksi2','limit_produksi3')->where('idteam',$team)->get();

        return view('Produksi.produksi', compact('splitProses1', 'splitProses2', 'splitProses3', 'defect1', 'defect2', 'defect3', 'user', 'namaSesi', 'valueSesi','proses1','proses2','proses3','limit'));
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
        $mesinProduksi = $request->get('mesinProduksi');

        if ($produk == '') {
            return response()->json(array(
                'msg' => 'maaf, tolong pilih produk yang ingin diproduksi terlebih dahulu',
                'code' => '401'
            ), 200);
        }


        if ($sesi == 1) {
            if ($jumlah > 50) {
                return response()->json(array(
                    'msg' => 'maaf, jumlah yang ingin kamu produksi melebihi kapasitas produksi',
                    'code' => '401'
                ), 200);
            }
        } else {

            //cek level mesin
            $splitMesin = explode(';', $mesinProduksi);
            foreach($splitMesin as $mp){
                if($mp != ""){
                    if($mp != "Idle"){
                        if($mp != "Delay"){
                            $levelMesin = DB::table('teams as t')
                                ->join('mesin_has_teams as mht', 't.idteam', '=', 'mht.teams_idteam')
                                ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
                                ->select('mht.level')
                                ->where('t.idteam', $team)
                                ->where('m.nama', $mp)
                                ->get();

                            // return $levelMesin;

                            if($levelMesin[0]->level < ($sesi - 1)){
                                return response()->json(array(
                                    'msg' => 'maaf, mesin '.$mp. ' belum mencapai level '.($sesi - 1),
                                    'code' => '401'
                                ), 200);

                            }
                        }
                    }
                }
            }


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
            // return $analisisProses[0][0];

            if (($jumlah > $analisisProses[0][0]) || ($jumlah > $analisisProses[0][1])) {
                return response()->json(array(
                    'msg' => 'maaf, jumlah yang ingin kamu produksi melebihi kapasitas produksi',
                    'code' => '401'
                ), 200);
            }
        }

        $bahanBaku = DB::table('produk')->select('bahan_baku')->where('idproduk', $produk)->get();
        $bahanBaku_split = explode(';', $bahanBaku[0]->bahan_baku);
        $limit = 'limit_produksi'.$btn;

        //ambil status team
        $teamStatus = DB::table('teams')->select('dana', 'inventory', $limit.' as limit', 'total_defect', 'total_berhasil')->where('idteam', $team)->get();

        //get inventory
        $newInv = $teamStatus[0]->inventory;

        if ($teamStatus[0]->dana < 100) {
            return response()->json(array(
                'msg' => 'maaf, maaf dana mu kurang untuk membuat product',
                'code' => '401'
            ), 200);
        }
        if($teamStatus[0]->limit <$jumlah  ){
            return response()->json(array(
                'msg' => 'maaf, jumlah yang ingin kamu produksi melebihi limit proses',
                'code' => '401'
            ), 200);
        }

        $stockINV = array();
        $whereBahanBaku = array();
        $countCukup = 0;

        //bahan baku harusnya bisa untuk sesi selanjutnya
        foreach ($bahanBaku_split as $bb) {
            //ubah
            $inv = DB::table('inventory')
                ->select('stock','ig_markets')
                ->where('inventory.teams', $team)
                ->where('ig_markets', 'like', "%" . $bb . "%")
                ->get();
            if (count($inv) > 0) {
                //ubah
                if($jumlah > $inv[0]->stock){
                    return response()->json(array(
                        'msg' => 'maaf, bahan baku mu kurang untuk membuat product',
                        'code' => '401'
                    ), 200);
                }
                else{
                    $countCukup +=1;
                    array_push($stockINV, $inv[0]->stock);
                    array_push($whereBahanBaku,  $inv[0]->ig_markets);
                    $newInv += $jumlah;
                }
                // if ($jumlah > $inv[0]->stock) {
                //     DB::table('teams')->where('idteam', $team)->update([
                //         'inventory'     => $newInv,
                //     ]);
                //     return response()->json(array(
                //         'msg' => 'maaf, bahan baku mu kurang untuk membuat product',
                //         'code' => '401'
                //     ), 200);
                // } else {
                //     $invBaru = $inv[0]->stock - $jumlah;
                //     $newInv += $jumlah;

                //     DB::table('inventory')
                //         ->where('ig_markets', $inv[0]->idig_markets)
                //         ->where('teams', $team)
                //         ->update(['stock' => $invBaru]);
                // }
            } else {
                DB::table('teams')->where('idteam', $team)->update([
                    'inventory'     => $newInv,
                ]);
                return response()->json(array(
                    'msg' => 'maaf, bahan baku mu kurang untuk membuat product',
                    'code' => '401'
                ), 200);
            }
        }

        if($countCukup == 3){
            DB::table('inventory')->where('teams', $team)->where('ig_markets', $whereBahanBaku[0])->update(['stock'=> ($stockINV[0]-$jumlah)]);
            DB::table('inventory')->where('teams', $team)->where('ig_markets', $whereBahanBaku[1])->update(['stock'=> ($stockINV[1]-$jumlah)]);
            DB::table('inventory')->where('teams', $team)->where('ig_markets', $whereBahanBaku[2])->update(['stock'=> ($stockINV[2]-$jumlah)]);
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
        $histori = DB::table('history_produksi')->select('hasil')->where('teams_idteam', $team)->where('produk_idproduk', $produk)->where('sesi',$sesi)->get();
        if (count($histori) > 0) {
            $hasil += $histori[0]->hasil;
        }

        // $totBahan = $jumlah * 3;
        // $newInv = $teamStatus[0]->inventory + $totBahan;
        $produkDefect = $jumlah - $hasil_user;
        $newDefect = $teamStatus[0]->total_defect + $produkDefect;
        $newBerhasil = $teamStatus[0]->total_berhasil + $hasil;
        $newDana = $teamStatus[0]->dana - 0;
        $newLimit = $teamStatus[0]->limit - $jumlah;
        DB::table('history_produksi')
            ->updateOrInsert(
                ['teams_idteam' => $team, 'produk_idproduk' => $produk, 'sesi' => $sesi],
                ['hasil' => $hasil]
            );
        DB::table('teams')->where('idteam', $team)->update([
            'dana'              => $newDana,
            'inventory'         => $newInv,
            $limit              => $newLimit,
            'total_defect'      => $newDefect,
            'total_berhasil'    => $newBerhasil,
        ]);

        return response()->json(array(
            'msg' => 'selamat kamu berhasil melakukan produksi ' . $name . ' sebanyak ' . $hasil_user . ' dengan defect produk sebanyak '. $produkDefect,
            'code' => '200'
        ), 200);
    }
}
