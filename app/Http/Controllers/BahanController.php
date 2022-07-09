<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class BahanController extends Controller
{
    function bahan()
    {
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
        $sesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();

        $product = DB::table('produk')->get();

        return view('Analisis_Bahan_Baku.bahan', compact('user', 'sesi', 'product'));
    }

    function analisisBahan(Request $request)
    {
        $produk = $request->get('produk');
        $resource1 = $request->get('resource1');
        $resource2 = $request->get('resource2');
        $resource3 = $request->get('resource3');
        $status = 'FALSE';

        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $bahanProduct = DB::table('produk')->select('nama', 'bahan_baku')->where('nama', 'like', '%' . $produk . '%')->get();

        $arrGuess = [$resource1, $resource2, $resource3];
        $arrBahan = explode(';', $bahanProduct[0]->bahan_baku);

        foreach ($arrBahan as $x => $bahan) {
            foreach ($arrGuess as $y => $tebak) {
                if ($bahan === $tebak) {
                    unset($arrBahan[$x]);
                    unset($arrGuess[$y]);
                }
            }
        }

        if (count($arrBahan) === 0) {
            $status  = 'TRUE';
        }

        $dana = $user[0]->dana;
        $harga = 500;

        if ($dana >= $harga) {
            DB::table('teams')
                ->where('idteam', $user[0]->idteam)
                ->update(['dana' => ($dana - $harga)]);
        } else {
            return response()->json(array(
                'msg' => 'Dana Tidak Mencukupi'
            ), 200);
        }

        $updatedUser = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        return response()->json(array(
            'user' => $updatedUser,
            'status' => $status
        ), 200);
    }
}
