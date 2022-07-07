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
        $sesi = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();
        return view('adminsesi', compact('sesi'));
    }

    function gantiSesi(Request $request)
    {
        $sekarang = $request->get('sesi');

        $upSesi = $sekarang + 1;
        if ($sekarang == 6) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Max Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($upSesi)]);
        }

        $updated = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();

        $team = DB::table('teams')
            ->select('idteam', 'dana', 'hibah')
            ->get();

        if ($upSesi == 3) {
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

        return response()->json(array(
            'sesi' => $updated
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

        $updated = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();

        return response()->json(array(
            'sesi' => $updated
        ), 200);
    }
}
