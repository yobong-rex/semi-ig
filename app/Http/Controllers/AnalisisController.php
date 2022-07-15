<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Events\Analisis;
use Illuminate\Http\Response;

class AnalisisController extends Controller
{
    function analisi()
    {
        $sesi = DB::table('sesi')->select('sesi', 'analisis')->get();
        if ($sesi[0]->analisis == true) {
            $team = Auth::user()->teams_idteam;
            $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
            $proses1 = '';
            $proses2 = '';
            $proses3 = '';
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

            

            $proses1DB = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 1)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses2DB = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 2)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses3DB = DB::table('teams_has_analisis')
                ->join('analisis', 'teams_has_analisis.analisis_idanalisis', '=', 'analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam', $team)
                ->where('analisis.produksi', 3)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();

            if(count($proses1DB)>0){
                $proses1 = $proses1DB[0]->proses;
            }
            if(count($proses2DB)>0){
                $proses2 = $proses2DB[0]->proses;
            }
            if(count($proses3DB)>0){
                $proses3 = $proses3DB[0]->proses;
            }

            return view('Sesi_Analisis.analisis', compact('mesin', 'user', 'sesi','proses1','proses2','proses3'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    function insertProses(Request $request)
    {
        $this->authorize('isProduction_Manager');
        $produksi = $request->get('produksi');
        $length = $request->get('panjang');
        $proses = $request->get('proses');
        $kapasitas = $request->get('kapasitas');
        $cycle = $request->get('cycle');
        $arrProses = $request->get('arrProses');

        $x = 4;
        if ($length < $x) {
            return response()->json(array(
                'msg' => 'x'
            ), 200);
        }

        //mencari kapasitas terkecil
        $minKpasitas = min($kapasitas);

        //mencari cycletime
        $time = array_sum($cycle);
        //9000/cycle time
        $cycleTime = intval(9000 / $time);

        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();



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
        $sesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi = $sesi[0]->nama;
        $pusher = ['status'=>$status, 'sesi'=> $sesi];
        event(new Analisis($pusher));
        return redirect()->route('analisis.admin')->with('status', 'status sesi analisis berhasil diubah');
    }
}
