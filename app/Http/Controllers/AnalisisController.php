<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Events\Analisis;
use App\Events\Mesin;
use Illuminate\Http\Response;

class AnalisisController extends Controller
{
    function analisi()
    {
        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama', 's.analisis')
            ->get();
        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        if ($namaSesi == 'Cooldown') {
            return redirect('/');
        }

        if ($getSesi[0]->analisis == true) {
            $team = Auth::user()->teams_idteam;
            $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
            $proses1 = '';
            $proses2 = '';
            $proses3 = '';

            $mesin = DB::table('mesin as m')
                ->join('mesin_has_teams as mht', 'm.idmesin', '=', 'mht.mesin_idmesin')
                ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
                ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
                ->select('m.idmesin', 'm.nama', 'mht.cycleTime', 'k.kapasitas')
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

            if (count($proses1DB) > 0) {
                $proses1 = $proses1DB[0]->proses;
            }
            if (count($proses2DB) > 0) {
                $proses2 = $proses2DB[0]->proses;
            }
            if (count($proses3DB) > 0) {
                $proses3 = $proses3DB[0]->proses;
            }

            return view('Sesi_Analisis.analisis', compact('mesin', 'user', 'valueSesi', 'namaSesi', 'proses1', 'proses2', 'proses3'));
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

        // mencari kapasitas terkecil
        $minKpasitas = min($kapasitas);

        // mencari cycletime
        $time = array_sum($cycle);

        // 9000/cycle time
        $cycleTime = intval(9000 / $time);

        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $dana = $user[0]->dana;
        $harga = 150;
        if ($dana >= $harga) {
            DB::table('teams')
                ->where('idteam', $user[0]->idteam)
                ->update(['dana' => ($dana - $harga)]);
        } else {
            return response()->json(array(
                'msg' => 'Dana Tidak Mencukupi'
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

        //memasukan cycleTime ke users
        DB::table('teams')
            ->where('idteam', $user[0]->idteam)
            ->update(['limit_produksi' . $produksi => $cycleTime]);

        $updatedUser = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        // $notEfficient = [];
        $efficient = [];
        if ($produksi == 1) {
            // $notEfficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Delay', 'Cutting', 'Assembling', 'Sorting', 'Packing'];
            $efficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];
        } else if ($produksi == 2) {
            // $notEfficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Delay', 'Cutting', 'Assembling', 'Idle', 'Packing'];
            $efficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Packing'];
        } elseif ($produksi == 3) {
            // $notEfficient = ['Sorting', 'Molding', 'Idle', 'Assembling', 'Sorting', 'Delay', 'Assembling', 'Packing'];
            $efficient = ['Sorting', 'Molding', 'Assembling', 'Packing'];
        }

        $status = 'false';
        $arrayProses = $arrProses;
        $arrEff = $efficient;
        $count = count($arrEff);
        if (count($arrEff) == $length) {
            for ($x = 0; $x < $count; $x++) {
                if ($arrayProses[$x] == $arrEff[$x]) {
                    unset($arrayProses[$x]);
                    unset($arrEff[$x]);
                }
            }

            if (count($arrEff) == 0) {
                $status = 'true';

                return response()->json(array(
                    'user' => $updatedUser,
                    'status' => $status
                ), 200);
            }

            foreach ($arrEff as $a => $isi_a) {
                foreach ($arrayProses as $b => $isi_b) {
                    if ($isi_a == $isi_b) {
                        unset($arrEff[$a]);
                        unset($arrayProses[$b]);
                    }
                }
            }

            if (count($arrEff) == 0) {
                $status = 'half';

                return response()->json(array(
                    'user' => $updatedUser,
                    'status' => $status
                ), 200);
            }
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
        $sesiVal = $sesi[0]->nama;

        $pusher = ['status' => $status, 'sesi' => $sesiVal];
        event(new Analisis($pusher));

        return redirect()->route('analisis.admin')->with('status', 'status sesi analisis berhasil diubah');
    }
}
