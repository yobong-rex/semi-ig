<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class AnalisisController extends Controller
{
    function analisi()
    {
        $sesi = DB::table('sesi')->select('sesi', 'analisis')->get();
        if ($sesi[0]->analisis == true) {
            $team = Auth::user()->teams_idteam;
            $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
            // $mesin = DB::table('mesin')
            //     ->join('view_kapasitas_mesin', 'mesin.idmesin', '=', 'view_kapasitas_mesin.mesin_id')
            //     ->join('mesin_has_teams', 'mesin.idmesin', '=', 'mesin_has_teams.mesin_idmesin')
            //     ->select('mesin.idmesin', 'mesin.nama', 'mesin.cycle', 'view_kapasitas_mesin.kapasitas')
            //     ->where('mesin_has_teams.teams_idteam', $user[0]->idteam)
            //     ->where('view_kapasitas_mesin.team', $user[0]->idteam)
            //     ->get();

            $mesin = DB::table('mesin as m')
                ->join('mesin_has_teams as mht', 'm.idmesin', '=', 'mht.mesin_idmesin')
                ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
                ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
                ->select('m.idmesin', 'm.nama', 'm.cycle', 'k.kapasitas')
                ->where('mht.teams_idteam', $user[0]->idteam)
                ->where('kht.teams_idteam', $user[0]->idteam)
                ->get();

            return view('Sesi_Analisis.analisis', compact('mesin', 'user', 'sesi'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    function insertProses(Request $request)
    {
        $produksi = $request->get('produksi');
        $length = $request->get('panjang');
        $proses = $request->get('proses');
        $kapasitas = $request->get('kapasitas');
        $cycle = $request->get('cycle');
        $arrProses = $request->get('arrProses');

        //mencari kapasitas terkecil
        $minKpasitas = min($kapasitas);

        //mencari cycletime
        $time = array_sum($cycle);
        //9000/cycle time
        $cycleTime = intval(9000 / $time);

        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $x = 4;
        if ($length < $x) {
            return response()->json(array(
                'msg' => 'Proses Kurang Panjang, Minimal Proses = 4'
            ), 200);
        }

        DB::table('analisis')->insert([
            'produksi' => $produksi,
            'length' => $length
        ]);

        // buat dapetin id terakhir yang diinsert
        $idanalisis = DB::getPdo()->lastInsertId();
        DB::table('teams_has_analisis')->insert([
            'teams_idteam' => $user[0]->idteam,
            'analisis_idanalisis' => $idanalisis,
            'proses' => $proses,
            'maxProduct' => $minKpasitas,
            'cycleTime' => $cycleTime
        ]);

        $dana = $user[0]->dana;
        $harga = 700;
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

        $notEfficient = [];
        $efficient = [];
        if ($produksi == 1) {
            $notEfficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Delay', 'Cutting', 'Assembling', 'Sorting', 'Packing'];
            $efficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];
        } else if ($produksi == 2) {
            $notEfficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Delay', 'Cutting', 'Assembling', 'Idle', 'Packing'];
            $efficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Packing'];
        } elseif ($produksi == 3) {
            $notEfficient = ['Sorting', 'Molding', 'Idle', 'Assembling', 'Sorting', 'Delay', 'Assembling', 'Packing'];
            $efficient = ['Sorting', 'Molding', 'Assembling', 'Packing'];
        }


        $status = true;
        if (count($efficient) == $length) {
            for ($x = 0; $x < count($efficient); $x++) {
                if ($efficient[$x] != $arrProses[$x]) {
                    $status = false;
                }
            }
        } else if (count($notEfficient) == $length) {
            for ($x = 0; $x < count($notEfficient); $x++) {
                if ($notEfficient[$x] != $arrProses[$x]) {
                    $status = false;
                }
            }
        } else {
            $status = false;
        }

        return response()->json(array(
            'user' => $updatedUser,
            'status' => $status
        ), 200);
    }

    function admin()
    {
        $data = DB::table('sesi')->select('analisis')->get();
        return view('Analisis_Bahan_Baku.admin', compact('data'));
    }

    function updateSesi(Request $request)
    {
        $status = $request->get('status');
        DB::table('sesi')->where('idsesi', 1)->update(['analisis' => $status]);
        return redirect()->route('analisis.admin')->with('status', 'status sesi analisis berhasil diubah');
    }
}
