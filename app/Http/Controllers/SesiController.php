<?php

namespace App\Http\Controllers;

use App\Events\Sesi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class SesiController extends Controller
{
    function sesi()
    {
        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();

        return view('adminsesi', compact('sesi'));
    }

    function startSesi()
    {
        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'start'));

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

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'pause'));

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

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, 'stop'));

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
            ->select('idteam', 'dana', 'hibah')
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

        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 'ws.waktu')
            ->get();

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, true));

        return response()->json(array(
            "success" => true,
            "sesi" => $sesi
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

        event(new Sesi($sesi[0]->sesi, $sesi[0]->nama, $sesi[0]->waktu, true));

        return response()->json(array(
            "success" => true,
            "sesi" => $sesi
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
