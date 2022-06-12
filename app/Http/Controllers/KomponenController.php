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
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();

        $idmesin = DB::table('mesin')->where('nama', 'like', '%Sorting%')->get();

        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin' , $idmesin[0]->idmesin)
            ->get();

            // dd($data);
        return view('Mesin.komponen', compact('data', 'user'));
    }

    function komponenUpgrade(Request $request)
    {
        $namaMesin = $request->get('namaMesin');
        $user = DB::table('teams')->select('nama', 'dana', 'idteam')->where('idteam', 1)->get();
        $idmesin = DB::table('mesin')->where('nama', 'like', '%'.$namaMesin.'%')->get();
        $data = DB::table('mesin as m')
            ->join('komponen as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('level_komponen as lk', 'k.idkomponen', '=', 'lk.komponen_idkomponen')
            ->where('lk.teams_idteam', $user[0]->idteam)
            ->where('m.idmesin' , $idmesin[0]->idmesin)
            ->get();

            // dd($data);
        return view('Mesin.komponen', compact('data', 'user'));
    }
}
