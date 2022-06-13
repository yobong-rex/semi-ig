<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class BahanController extends Controller
{
    function bahan(){
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
        $sesi = DB::table('sesi')->select('sesi')->get();

        return view('Analisis_Bahan_Baku.bahan', compact('user', 'sesi'));
    }

    function analisisBahan(){
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $dana = $user[0]->dana;
        $harga = 500;

        if($dana >= $harga){
            DB::table('teams')
            ->where('idteam', $user[0]->idteam)
            ->update(['dana' => ($dana-$harga)]);
        }
        else{
            return response()->json(array(
                'msg' => 'Dana Tidak Mencukupi'
            ), 200);
        }

        $updatedUser = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        return response()->json(array(
            'user' => $updatedUser
        ), 200);
    }
}
