<?php

namespace App\Http\Controllers;

use App\Events\Sesi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;

class SesiController extends Controller
{
    function sesi()
    {
        $user = DB::table('users')->select(DB::raw('name as nama'))->where('id', 26)->get();

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
            'status' => 'Started'
        ), 200);
    }

    function pauseSesi()
    {
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
        $sekarang = $request->get('sesi');

        $upSesi = $sekarang + 1;
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
            ->select('idteam', 'dana', 'hibah','total_pendapatan')
            ->get();

        // nambah hibah ke dana
        if ($upSesi == 5) {
            foreach ($team as $t) {
                $dblDana = (float)$t->dana;
                $danaPlus = ($dblDana) + ($t->hibah);
                $hibahBaru = ($t->hibah) - ($t->hibah);
                $danaBaru = (int)floor($danaPlus);
                DB::table('teams')
                    ->where('idteam', $t->idteam)
                    ->update([
                        'dana' => ($danaBaru),
                        'hibah' => ($hibahBaru)
                    ]);
            }
        }

        //over production
        foreach ($team as $t){
            $overProd = DB::table('history_produksi')->where('teams_idteam',$t->idteam)->where('sesi', $sekarang)->where('hasil','>',0)->get();
            $temp = 0;
            if(count($overProd)>0){
                foreach ($overProd as $op){
                    $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk',$op->produk_idproduk)->get();
                    $temp += ($op->hasil * floor($hargaProduk[0]->harga_jual * 40 /100));
                }
                $danaBaru = $t->dana + $temp;
                $totalPendapatanBaru = $t->total_pendapatan + $temp;

                DB::table('teams')->where('idteam', $t->idteam)->update(['dana'=>$danaBaru, 'total_pendapatan'=>$totalPendapatanBaru]);
            }
        }

        //reset cycle time per tim
        foreach ($team as $t){
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
                    ->select( 'cycleTime')
                    ->where('analisis_idanalisis', $idAP->maxIdAnalisis)
                    ->get();
                $analisisProses[] = array($arrAP[0]->cycleTime);
            }

            DB::table('teams')
                ->where('idteam', $t->idteam)
                ->update(['limit_produksi1' => $analisisProses[0][0], 'limit_produksi2' => $analisisProses[1][0], 'limit_produksi3' => $analisisProses[2][0]]);
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
            'status' => 'Started'
        ), 200);
    }

    function backSesi(Request $request)
    {
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
            'status' => 'Started'
        ), 200);
    }

    function timer(Request $request)
    {
        $namaSesi = $request->get('namaSesi');

        $waktu_sesi = DB::table('waktu_sesi')->select('waktu')->where('nama', 'like', '%' . $namaSesi . '%')->get();

        return response()->json(array(
            'waktu' => $waktu_sesi
        ));
    }
}
