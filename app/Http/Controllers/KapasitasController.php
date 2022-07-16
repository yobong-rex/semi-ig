<?php

namespace App\Http\Controllers;

use App\Kapasitas;
use Illuminate\Http\Request;
use DB;
use Auth;

class KapasitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //search all
        // $kapasitas = DB::table('kapasitas')->get();

        //search where
        // $kapasitas = DB::table('kapasitas')->where('level','1')->get();        

        //join
        // $kapasitas = DB::table('kapasitas')
        // ->join('mesin','kapasitas.mesin_idmesin', '=', 'mesin.idmesin')
        // ->select('mesin.*', 'kapasitas.*')->get();

        //advanced join
        // $kapasitas = DB::table('kapasitas')->join('mesin', function ($join) {
        //     $join->on('kapasitas.mesin_idmesin', '=', 'mesin.idmesin')
        //          ->where('kapasitas.level', '<', 2);
        // })->get();    

        // return view('Mesin.kapasitas', compact('kapasitas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Kapasitas  $kapasitas
     * @return \Illuminate\Http\Response
     */
    public function show(Kapasitas $kapasitas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kapasitas  $kapasitas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kapasitas $kapasitas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kapasitas  $kapasitas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kapasitas $kapasitas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kapasitas  $kapasitas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kapasitas $kapasitas)
    {
        //
    }

    function kapasitas()
    {
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();
        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        $data = DB::table('mesin as m')
            ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
            ->select('kht.teams_idteam', 'm.nama', 'k.level', 'k.kapasitas')
            ->where('kht.teams_idteam', $user[0]->idteam)
            ->orderBy('m.idmesin', 'asc')
            ->get();

        return view('Mesin.kapasitas', compact('data', 'user', 'valueSesi', 'namaSesi'));
    }

    function kapasitasUpgrade(Request $request)
    {
        $this->authorize('isProduction_Manager');
        $team = Auth::user()->teams_idteam;
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', $team)->get();
        $namaMesin = $request->get('namaMesin');
        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $idkap = DB::table('kapasitas_has_teams as kht')
            ->join('kapasitas as k', 'kht.kapasitas_idkapasitas', '=', 'k.idkapasitas')
            ->select('kht.kapasitas_idkapasitas', 'k.level', 'k.harga')
            ->where('kht.teams_idteam', $user[0]->idteam)
            ->where('kht.kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
            ->get();

        $upgrade = $idkap[0]->kapasitas_idkapasitas;
        $level = $idkap[0]->level;
        $dana = $user[0]->dana;
        $harga = $idkap[0]->harga;

        if ($level < 5) {
            if ($dana >= $harga) {
                $upgrade += 1;
                DB::table('kapasitas_has_teams')
                    ->where('teams_idteam', $user[0]->idteam)
                    ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
                    ->update(['kapasitas_idkapasitas' => $upgrade]);

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

        $updatedUser = DB::table('teams')->select('dana')->where('idteam', $user[0]->idteam)->get();

        $data = DB::table('mesin as m')
            ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
            ->select('m.nama', 'k.level', 'k.kapasitas')
            ->where('kht.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->get();
        // dd($data);
        return response()->json(array(
            'data' => $data,
            'user' => $updatedUser,
            'msg' => 'Upgrade Successful'
        ), 200);
        // return view('Mesin.kapasitas', compact('data'));
    }
}
