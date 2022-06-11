<?php

namespace App\Http\Controllers;

use App\Kapasitas;
use Illuminate\Http\Request;
use DB;

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
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();
        $data = DB::table('mesin as m')
            ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
            ->select('kht.teams_idteam', 'm.nama', 'k.level', 'k.kapasitas')
            ->where('kht.teams_idteam', $user[0]->idteam)
            ->orderBy('m.idmesin', 'asc')
            ->get();
        // dd($data);
        return view('Mesin.kapasitas', compact('data'));
    }

    function kapasitasUpgrade(Request $request)
    {
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();
        $namaMesin = $request->get('namaMesin');
        $idmesin = DB::table('mesin')->where('nama', 'like', '%' . $namaMesin . '%')->get();

        $idkap = DB::table('kapasitas_has_teams')
            ->select('kapasitas_idkapasitas')
            ->where('teams_idteam', $user[0]->idteam)
            ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
            ->get();

        $upgrade = $idkap[0]->kapasitas_idkapasitas;
        $level = DB::table('kapasitas')
            ->select('level')
            ->where('idkapasitas', $upgrade)
            ->get();

        // return $upgrade;
        // return $level[0]->level;
        if ($level[0]->level < 5) {
            $upgrade += 1;
            DB::table('kapasitas_has_teams')
                ->where('teams_idteam', $user[0]->idteam)
                ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
                ->update(['kapasitas_idkapasitas' => $upgrade]);
        } else {
            return response()->json(array(
                'msg' => 'Level Maxed'
            ), 200);
        }

        $data = DB::table('mesin as m')
            ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
            ->select('m.nama', 'k.level', 'k.kapasitas')
            ->where('kht.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin', $idmesin[0]->idmesin)
            ->get();
        // dd($data);
        return view('Mesin.kapasitas', compact('data'));
    }
}
