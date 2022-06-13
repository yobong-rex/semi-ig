<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        if ($sekarang == 6) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Max Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($sekarang + 1)]);
        }

        $updated = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();

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
