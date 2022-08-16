<?php

namespace App\Http\Controllers;

use App\Events\Sesi;
use App\Events\Timer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;

class SesiController extends Controller
{
    function sesi()
    {
        $this->authorize('isSI');

        $team = Auth::user()->id;
        $user = DB::table('users')->select(DB::raw('name as nama'))->where('id', $team)->get();

        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();
        $valueSesi = $sesi[0]->sesi;
        $namaSesi = $sesi[0]->nama;

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        return view('adminsesi', compact('sesi', 'detail', 'valueSesi', 'namaSesi', 'user'));
    }

    function startSesi()
    {
        $this->authorize('isSI');

        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'start', $detail));

        return response()->json(array(
            "success" => true,
            'status' => 'Started',
            'waktu' => $sesi[0]->waktu
        ), 200);
    }

    function pauseSesi()
    {
        $this->authorize('isSI');

        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'pause', $detail));

        return response()->json(array(
            "success" => true,
            'status' => 'Paused'
        ), 200);
    }

    function stopSesi()
    {
        $this->authorize('isSI');

        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'stop', $detail));

        return response()->json(array(
            "success" => true,
            'status' => 'Stopped'
        ), 200);
    }

    function gantiSesi(Request $request)
    {
        $this->authorize('isSI');

        $sekarang = $request->get('sesi');

        $upSesi = $sekarang + 1;
        // $danaBaru= 0;


        if ($sekarang == 11) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Max Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($upSesi)]);
        }

        $team = DB::table('teams')
            ->select('idteam', 'dana', 'hibah', 'total_pendapatan','over_production')
            ->get();

        // nambah hibah ke dana
        // if ($upSesi == 5) {
        //     foreach ($team as $t) {
        //         $dblDana = (float)$t->dana;
        //         $danaPlus = ($dblDana) + ($t->hibah);
        //         $hibahBaru = ($t->hibah) - ($t->hibah);
        //         $danaBaru = (int)floor($danaPlus);
        //         DB::table('teams')
        //             ->where('idteam', $t->idteam)
        //             ->update([
        //                 'dana' => ($danaBaru),
        //                 'hibah' => ($hibahBaru)
        //             ]);
        //     }
        // }


        if($upSesi % 2 != 0){
            $getSesiSebelum = DB::table('waktu_sesi')->select('nama')->where('idwaktu_sesi', ($sekarang - 1))->get();
            $sesiSebelum = $getSesiSebelum[0]->nama;
            foreach ($team as $t) {
                //hibah
                $danaBaru = $t->dana;
                if($upSesi == 5){
                    $danaPlus = ($danaBaru) + ($t->hibah);
                    $hibahBaru = ($t->hibah) - ($t->hibah);
                    $danaBaru = (int)floor($danaPlus);
                    DB::table('teams')
                    ->where('idteam', $t->idteam)
                    ->update([
                            'dana' => ($danaBaru),
                            'hibah' => ($hibahBaru)
                        ]);
                    }

                //over production
                $overProd = DB::table('history_produksi')->where('teams_idteam', $t->idteam)->where('sesi', $sesiSebelum)->where('hasil', '>', 0)->get();
                $temp = 0;
                $tot_over = 0;
                if (count($overProd) > 0) {
                    foreach ($overProd as $op) {
                        $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk', $op->produk_idproduk)->get();
                        $temp += ($op->hasil * floor($hargaProduk[0]->harga_jual * 40 / 100));
                        $tot_over += $op->hasil;
                    }
                    $danaBaru += $temp;
                    $totalPendapatanBaru = $t->total_pendapatan + $temp;
                    $over_baru = $t->over_production + $tot_over;

                    $affected = DB::table('teams')->where('idteam', $t->idteam)->update(['dana' => $danaBaru, 'total_pendapatan' => $totalPendapatanBaru,  'over_production'=> $over_baru]);

                }

                //reset cycle time
                $idanalisisProses = DB::table('analisis as a')
                ->join('teams_has_analisis as tha', 'a.idanalisis', '=', 'tha.analisis_idanalisis')
                ->select(DB::raw('MAX(a.idanalisis) as maxIdAnalisis'))
                ->where('tha.teams_idteam', $t->idteam)
                    ->groupBy('a.produksi')
                    ->orderBy('a.idanalisis')
                    ->get();

                $analisisProses = [];
                foreach ($idanalisisProses as $idAP) {
                    $arrAP = DB::table('teams_has_analisis')
                    ->select('cycleTime')
                    ->where('analisis_idanalisis', $idAP->maxIdAnalisis)
                    ->get();
                    $analisisProses[] = array($arrAP[0]->cycleTime);
                }

                if (count($analisisProses) > 0) {
                    DB::table('teams')
                        ->where('idteam', $t->idteam)
                        ->update(['limit_produksi1' => $analisisProses[0][0], 'limit_produksi2' => $analisisProses[1][0], 'limit_produksi3' => $analisisProses[2][0]]);
                    }

                    // charge inventory
                    $teamInv = DB::table('inventory')->where('teams',$t->idteam)->where('stock','>',0)->get();
                    if(count($teamInv)> 0){
                        foreach($teamInv as $ti){
                            $danaBaru -= ($ti->stock * 2);
                            DB::table('teams')->where('idteam', $t->idteam)->update(['dana' => $danaBaru]);
                        }
                    }

            }

        }

        //reset inventory di sesi 5
        if($upSesi == 9){
            DB::table('inventory')->delete();
            foreach($team as $t){
                DB::table('teams')->where('idteam', $t->idteam)->update(['inventory'=> 450]);
            }
        }
        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'ganti', $detail));

        return response()->json(array(
            "success" => true,
            "sesi" => $sesi,
            'detail' => $detail,
            'status' => 'Started',
            'waktu' => $sesi[0]->waktu
        ), 200);
    }

    function backSesi(Request $request)
    {
        $this->authorize('isSI');

        $sekarang = $request->get('sesi');

        if ($sekarang == 1) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Gabisa Kurang Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($sekarang - 1)]);
        }

        $sesi = DB::table('sesi as s')->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')->select('s.sesi', 'ws.nama', 'ws.waktu')->get();

        $sesiAtas = $sesi[0]->sesi - 1;
        $sesiBawah = $sesi[0]->sesi + 1;

        if ($sesiAtas < 1 || $sesiBawah > 11 || $sesi[0]->nama != 'Cooldown') {
            $detail = $sesi[0]->nama;
        } else {
            $namaAtas = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiAtas)
                ->get();
            $namaBawah = DB::table('waktu_sesi')
                ->where('idwaktu_sesi', '=', $sesiBawah)
                ->get();
            $detail = $namaAtas[0]->nama . ' ke ' . $namaBawah[0]->nama;
        }

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'back', $detail));

        return response()->json(array(
            "success" => true,
            "sesi" => $sesi,
            'detail' => $detail,
            'status' => 'Started',
            'waktu' => $sesi[0]->waktu
        ), 200);
    }

    function timer(Request $request)
    {
        $minute = $request->get('minute');
        $second = $request->get('second');

        $status = $request->get('status');

        event(new Timer($minute, $second, $status));

        return response()->json(array(
            'status' => "Success"
        ));
    }
}
