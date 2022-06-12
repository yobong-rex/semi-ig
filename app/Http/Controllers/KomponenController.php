<?php

namespace App\Http\Controllers;

use App\Komponen;
use Illuminate\Http\Request;
use DB;

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
        $idmesin = DB::table('mesin')->where('nama', 'like', '%Sorting%')->get();

        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('m.nama as nama_mesin', 'k.nama as nama_komponen', 'k.level', 'k.defect')
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

        $dataMesin = DB::table('mesin as m')
            ->join('komponen as kom', 'm.idmesin', '=', 'kom.mesin_idmesin')
            ->join('kapasitas as kap', 'm.idmesin', '=', 'kap.mesin_idmesin')
            ->join('mesin_has_teams as mht', 'm.idmesin', '=', 'mht.mesin_idmesin')
            ->where(mht.)
            ->get();

        dd($dataMesin);
        return view('Mesin.komponen', compact('data', 'user', 'levelMesin'));
    }

    function komponenAjax(Request $request)
    {
        $namaMesin = $request->get('namaMesin');
        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();


        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('m.nama as nama_mesin', 'k.nama as nama_komponen', 'k.level', 'k.defect')
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
        $namaMesin = $request->get('namaMesin');
        $namaKomponen = $request->get('namaKomponen');
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();
        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $idkom = DB::table('level_komponen as lk')
            ->join('komponen as k', 'lk.komponen_idkomponen', '=', 'k.idkomponen')
            ->select('komponen_idkomponen', 'k.level')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('lk.komponen_mesin_idmesin', $idmesin[0]->idmesin)
            ->where('k.nama', $namaKomponen)
            ->get();

        $upgrade = $idkom[0]->komponen_idkomponen;
        $levelKomponen = $idkom[0]->level;

        if ($levelKomponen < 10) {
            $upgrade += 1;
            DB::table('level_komponen')
                ->where('teams_idteam', $user[0]->idteam)
                ->where('komponen_mesin_idmesin', $idmesin[0]->idmesin)
                ->where('komponen_idkomponen', $idkom[0]->komponen_idkomponen)
                ->update(['komponen_idkomponen' => $upgrade]);
        } else {
            return response()->json(array(
                'msg' => 'Level Maxed'
            ), 200);
        }

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->select('k.nama', 'k.level', 'k.defect')
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

        $level_mesin = 1;

        // Check Level
        if ($level_a == 10 && $level_b == 10 && $level_c == 10 && $level_d == 10) {
            $level_mesin = 6;
        } elseif ($level_a >= 8 && $level_b >= 8 && $level_c >= 8 && $level_d >= 8) {
            $level_mesin = 5;
        } elseif ($level_a >= 6 && $level_b >= 6 && $level_c >= 6 && $level_d >= 6) {
            $level_mesin = 4;
        } elseif ($level_a >= 4 && $level_b >= 4 && $level_c >= 4 && $level_d >= 4) {
            $level_mesin = 3;
        } elseif ($level_a >= 2 && $level_b >= 2 && $level_c >= 2 && $level_d >= 2) {
            $level_mesin = 2;
        }

        DB::table('mesin_has_teams')
            ->where('mesin_idmesin', $idmesin[0]->idmesin)
            ->where('teams_idteam', $user[0]->idteam)
            ->update(['level' => $level_mesin]);

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
}
