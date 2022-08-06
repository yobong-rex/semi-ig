<?php

namespace App\Http\Controllers;

use App\Komponen;
use App\Events\Mesin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;

class KomponenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function show(Komponen $komponen)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function edit(Komponen $komponen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komponen $komponen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Komponen  $komponen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Komponen $komponen)
    {
        //
    }

    function komponen()
    {
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $idmesin = DB::table('mesin')->where('nama', 'like', '%Sorting%')->get();
        $namaMesin = DB::table('mesin')->select('nama')->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();

        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('m.nama as nama_mesin', 'k.nama as nama_komponen', 'k.level')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->orderBy('k.idkomponen', 'asc')
            ->get();

        $levelMesin = DB::table('teams as t')
            ->join('mesin_has_teams as mht', 't.idteam', '=', 'mht.teams_idteam')
            ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
            ->select('mht.level')
            ->where('t.idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->get();

        return view('Mesin.komponen', compact('data', 'user', 'levelMesin', 'valueSesi', 'namaSesi', 'namaMesin'));
    }

    function komponenAjax(Request $request)
    {
        $this->authorize('isMarketing');
        $namaMesin = $request->get('namaMesin');
        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('m.nama as nama_mesin', 'k.nama as nama_komponen', 'k.level')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->orderBy('k.idkomponen', 'asc')
            ->get();

        $levelMesin = DB::table('teams as t')
            ->join('mesin_has_teams as mht', 't.idteam', '=', 'mht.teams_idteam')
            ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
            ->select('mht.level')
            ->where('t.idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->get();

        // dd($data);
        return response()->json(array(
            'data' => $data,
            'levelMesin' => $levelMesin
        ), 200);
        // return view('Mesin.komponen', compact('data', 'user', 'levelMesin'));
    }

    function komponenUpgrade(Request $request)
    {
        $this->authorize('isMarketing');
        $namaMesin = $request->get('namaMesin');
        $namaKomponen = $request->get('namaKomponen');
        // type upgrade all atau upgrade 1
        $type = $request->get('type');

        // data team
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam', 'limit_produksi1', 'limit_produksi2', 'limit_produksi3')->where('idteam', $team)->get();

        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $cycleTime = DB::table('mesin_has_teams')
            ->where('teams_idteam', '=', $user[0]->idteam)
            ->where('mesin_idmesin', '=', $idmesin[0]->idmesin)
            ->get();

        $dana = $user[0]->dana;

        // kalau upgrade all komponen
        if ($type == "all") {
            $komponen = DB::table('level_komponen as lk')
                ->join('komponen as k', 'lk.komponen_idkomponen', '=', 'k.idkomponen')
                ->where('lk.teams_idteam', $user[0]->idteam)
                ->where('lk.komponen_mesin_idmesin', $idmesin[0]->idmesin)
                ->get();

            $hargaTotal = [];
            $arrayLevel = [];
            $idLevel = [];
            $namaKom = [];
            foreach ($komponen as $kom) {
                array_push($hargaTotal, $kom->harga);
                array_push($arrayLevel, $kom->level);
                array_push($idLevel, $kom->komponen_idkomponen);
                array_push($namaKom, $kom->nama);
            }

            foreach ($arrayLevel as $lvl) {
                if ($lvl == 10) {
                    return response()->json(array(
                        'msg' => 'One of the Component has reached Max Level'
                    ), 200);
                }
            }

            $hargaTotal = array_sum($hargaTotal);

            if ($dana >= $hargaTotal) {
                $idUp = 0;
                $arrUp = [];

                foreach ($idLevel as $idLvl) {
                    $idUp = $idLvl + 1;
                    array_push($arrUp, $idUp);
                }

                for ($x = 0; $x < count($namaKom); $x++) {
                    DB::table('level_komponen as lk')
                        ->join('komponen as k', 'lk.komponen_idkomponen', '=', 'k.idkomponen')
                        ->where('lk.teams_idteam', $user[0]->idteam)
                        ->where('lk.komponen_mesin_idmesin', $idmesin[0]->idmesin)
                        ->where('k.nama', 'like', '%' . $namaKom[$x] . '%')
                        ->update(['komponen_idkomponen' => $arrUp[$x]]);
                }

                DB::table('teams')
                    ->where('idteam', $user[0]->idteam)
                    ->update(['dana' => ($dana - $hargaTotal)]);
            }
        }
        // kalau upgrade 1 komponen
        else {
            $idkom = DB::table('level_komponen as lk')
                ->join('komponen as k', 'lk.komponen_idkomponen', '=', 'k.idkomponen')
                ->select('komponen_idkomponen', 'k.level', 'k.harga')
                ->where('lk.teams_idteam', $user[0]->idteam)
                ->where('lk.komponen_mesin_idmesin', $idmesin[0]->idmesin)
                ->where('k.nama', $namaKomponen)
                ->get();

            $upgrade = $idkom[0]->komponen_idkomponen;
            $levelKomponen = $idkom[0]->level;
            $harga = $idkom[0]->harga;

            if ($levelKomponen < 10) {
                if ($dana >= $harga) {
                    $upgrade += 1;
                    DB::table('level_komponen')
                        ->where('teams_idteam', $user[0]->idteam)
                        ->where('komponen_mesin_idmesin', $idmesin[0]->idmesin)
                        ->where('komponen_idkomponen', $idkom[0]->komponen_idkomponen)
                        ->update(['komponen_idkomponen' => $upgrade]);

                    DB::table('teams')
                        ->where('idteam', $user[0]->idteam)
                        ->update(['dana' => ($dana - $harga)]);
                } else {
                    return response()->json(array(
                        'msg' => 'Dana Tidak Mencukupi'
                    ), 200);
                }
            } else {
                return response()->json(array(
                    'msg' => 'Level Maxed'
                ), 200);
            }
        }

        $updatedUser = DB::table('teams')->select('dana')->where('idteam', $user[0]->idteam)->get();

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('k.nama', 'k.level')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->orderBy('k.idkomponen', 'asc')
            ->get();

        $level_komponen = DB::table('level_komponen as lk')
            ->join('komponen as k', 'lk.komponen_idkomponen', '=', 'k.idkomponen')
            ->select('k.level')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('lk.komponen_mesin_idmesin', $idmesin[0]->idmesin)
            ->orderBy('k.idkomponen', 'asc')
            ->get();

        $level_a = $level_komponen[0]->level;
        $level_b = $level_komponen[1]->level;
        $level_c = $level_komponen[2]->level;
        $level_d = $level_komponen[3]->level;

        $level_mesin = DB::table('mesin_has_teams')
            ->where('mesin_idmesin', $idmesin[0]->idmesin)
            ->where('teams_idteam', $user[0]->idteam)
            ->get();

        $level_kapasitas = DB::table('kapasitas_has_teams')
            ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
            ->where('teams_idteam', $user[0]->idteam)
            ->get();

        $level_mesin = $level_mesin[0]->level;
        $level_kapasitas = $level_kapasitas[0]->kapasitas_idkapasitas;
        $cycle = $cycleTime[0]->cycleTime;

        // Check Level
        if ($level_a == 10 && $level_b == 10 && $level_c == 10 && $level_d == 10) {
            $level_mesin = 6;
            $level_kapasitas += 1;
            $cycle -= 1;
        } elseif ($level_a == 8 && $level_b == 8 && $level_c == 8 && $level_d == 8) {
            $level_mesin = 5;
            $level_kapasitas += 1;
            $cycle -= 1;
        } elseif ($level_a == 6 && $level_b == 6 && $level_c == 6 && $level_d == 6) {
            $level_mesin = 4;
            $level_kapasitas += 1;
            $cycle -= 1;
        } elseif ($level_a == 4 && $level_b == 4 && $level_c == 4 && $level_d == 4) {
            $level_mesin = 3;
            $level_kapasitas += 1;
            $cycle -= 1;
        } elseif ($level_a == 2 && $level_b == 2 && $level_c == 2 && $level_d == 2) {
            $level_mesin = 2;
            $level_kapasitas += 1;
            $cycle -= 1;
        }

        DB::table('mesin_has_teams')
            ->where('mesin_idmesin', $idmesin[0]->idmesin)
            ->where('teams_idteam', $user[0]->idteam)
            ->update([
                'level' => $level_mesin,
                'cycleTime' => $cycle
            ]);

        DB::table('kapasitas_has_teams')
            ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
            ->where('teams_idteam', $user[0]->idteam)
            ->update([
                'kapasitas_idkapasitas' => $level_kapasitas
            ]);

        $levelMesin = DB::table('teams as t')
            ->join('mesin_has_teams as mht', 't.idteam', '=', 'mht.teams_idteam')
            ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
            ->select('mht.level')
            ->where('t.idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->get();

        // start (ambil id analisis produksi terakhir)
        $idProduksi1 = DB::table('teams_has_analisis as tha')
            ->join('analisis as a', 'tha.analisis_idanalisis', '=', 'a.idanalisis')
            ->select(DB::raw('max(a.idanalisis) as maxIdAnalisis'), DB::raw('a.length as length'))
            ->where('tha.teams_idteam', '=', $user[0]->idteam)
            ->where('a.produksi', '=', 1)
            ->get();

        $idProduksi2 = DB::table('teams_has_analisis as tha')
            ->join('analisis as a', 'tha.analisis_idanalisis', '=', 'a.idanalisis')
            ->select(DB::raw('max(a.idanalisis) as maxIdAnalisis'), DB::raw('a.length as length'))
            ->where('tha.teams_idteam', '=', $user[0]->idteam)
            ->where('a.produksi', '=', 2)
            ->get();

        $idProduksi3 = DB::table('teams_has_analisis as tha')
            ->join('analisis as a', 'tha.analisis_idanalisis', '=', 'a.idanalisis')
            ->select(DB::raw('max(a.idanalisis) as maxIdAnalisis'), DB::raw('a.length as length'))
            ->where('tha.teams_idteam', '=', $user[0]->idteam)
            ->where('a.produksi', '=', 3)
            ->get();
        // end (ambil id analisis produksi terakhir)

        // start (ambil proses)
        $produksi1 = DB::table('teams_has_analisis')
            ->select('proses')
            ->where('analisis_idanalisis', '=', $idProduksi1[0]->maxIdAnalisis)
            ->where('proses', 'like', '%' . $namaMesin . '%')
            ->get();

        $produksi2 = DB::table('teams_has_analisis')
            ->select('proses')
            ->where('analisis_idanalisis', '=', $idProduksi2[0]->maxIdAnalisis)
            ->where('proses', 'like', '%' . $namaMesin . '%')
            ->get();

        $produksi3 = DB::table('teams_has_analisis')
            ->select('proses')
            ->where('analisis_idanalisis', '=', $idProduksi3[0]->maxIdAnalisis)
            ->where('proses', 'like', '%' . $namaMesin . '%')
            ->get();
        // end (ambil proses)

        $arrCycle1 = [];
        $arrCycle2 = [];
        $arrCycle3 = [];

        if (count($produksi1) != 0) {
            $proses1 = explode(';', $produksi1[0]->proses);

            for ($x = 0; $x < $idProduksi1[0]->length; $x++) {
                $cycle1 =  DB::table('mesin_has_teams as mht')
                    ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
                    ->select(DB::raw('mht.cycleTime as cycle'))
                    ->where('mht.teams_idteam', '=', $user[0]->idteam)
                    ->where('m.nama', 'like', '%' . $proses1[$x] . '%')
                    ->get();

                array_push($arrCycle1, $cycle1[0]->cycle);
            }
        }

        if (count($produksi2) != 0) {
            $proses2 = explode(';', $produksi2[0]->proses);

            for ($x = 0; $x < $idProduksi2[0]->length; $x++) {
                $cycle2 =  DB::table('mesin_has_teams as mht')
                    ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
                    ->select(DB::raw('mht.cycleTime as cycle'))
                    ->where('mht.teams_idteam', '=', $user[0]->idteam)
                    ->where('m.nama', 'like', '%' . $proses2[$x] . '%')
                    ->get();

                array_push($arrCycle2, $cycle2[0]->cycle);
            }
        }

        if (count($produksi3) != 0) {
            $proses3 = explode(';', $produksi3[0]->proses);

            for ($x = 0; $x < $idProduksi3[0]->length; $x++) {
                $cycle3 =  DB::table('mesin_has_teams as mht')
                    ->join('mesin as m', 'mht.mesin_idmesin', '=', 'm.idmesin')
                    ->select(DB::raw('mht.cycleTime as cycle'))
                    ->where('mht.teams_idteam', '=', $user[0]->idteam)
                    ->where('m.nama', 'like', '%' . $proses3[$x] . '%')
                    ->get();

                array_push($arrCycle3, $cycle3[0]->cycle);
            }
        }

        $cycleTime1 = '';
        $cycleTime2 = '';
        $cycleTime3 = '';

        //mencari cycletime
        if (count($arrCycle1) != 0) {
            $time1 = array_sum($arrCycle1);
            $cycleTime1 = intval(9000 / $time1);

            $cycleDulu1 =  DB::table('teams_has_analisis')
                ->select("cycleTime")
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi1[0]->maxIdAnalisis)
                ->get();

            //cari sesisih antara cycle time lama dan baru
            $selisih1 = $cycleTime1 - $cycleDulu1[0]->cycleTime;
            // var_dump($selisih);

            //update cycle time
            DB::table('teams_has_analisis')
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi1[0]->maxIdAnalisis)
                ->update(['cycleTime' => $cycleTime1]);

            //update limit produksi team
            DB::table('teams')->where('idteam', $user[0]->idteam)->update(['limit_produksi1' => ($user[0]->limit_produksi1 + $selisih1)]);
            // DB::table('teams')->increment('limit_produksi1', $selisih1,['idteam'=>$user[0]->idteam]);
            // return $selisih1;

        }

        if (count($arrCycle2) != 0) {
            $time2 = array_sum($arrCycle2);
            $cycleTime2 = intval(9000 / $time2);

            $cycleDulu2 =  DB::table('teams_has_analisis')
                ->select("cycleTime")
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi2[0]->maxIdAnalisis)
                ->get();

            //cari sesisih antara cycle time lama dan baru
            $selisih2 = $cycleTime2 - $cycleDulu2[0]->cycleTime;

            DB::table('teams_has_analisis')
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi2[0]->maxIdAnalisis)
                ->update(['cycleTime' => $cycleTime2]);

            //update limit produksi team
            DB::table('teams')->where('idteam', $user[0]->idteam)->update(['limit_produksi2' => ($user[0]->limit_produksi2 + $selisih2)]);
            // DB::table('teams')->increment('limit_produksi2', $selisih,['idteam'=>$user[0]->idteam]);
        }

        if (count($arrCycle3) != 0) {
            $time3 = array_sum($arrCycle3);
            $cycleTime3 = intval(9000 / $time3);

            $cycleDulu3 =  DB::table('teams_has_analisis')
                ->select("cycleTime")
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi3[0]->maxIdAnalisis)
                ->get();

            //cari sesisih antara cycle time lama dan baru
            $selisih3 = $cycleTime3 - $cycleDulu3[0]->cycleTime;

            DB::table('teams_has_analisis')
                ->where('teams_idteam', '=', $user[0]->idteam)
                ->where('analisis_idanalisis', '=', $idProduksi3[0]->maxIdAnalisis)
                ->update(['cycleTime' => $cycleTime3]);

            //update limit produksi team
            DB::table('teams')->where('idteam', $user[0]->idteam)->update(['limit_produksi3' => ($user[0]->limit_produksi3 + $selisih3)]);
            // DB::table('teams')->increment('limit_produksi3', $selisih,['idteam'=>$user[0]->idteam]);
        }

        event(new Mesin($user[0]->idteam, '', $cycleTime1, '', $cycleTime2, '', $cycleTime3));

        return response()->json(array(
            'data' => $data,
            'user' => $updatedUser,
            'levelMesin' => $levelMesin,
            'msg' => 'Upgrade Successful'
        ), 200);
    }
}
