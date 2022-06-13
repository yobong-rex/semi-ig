<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use DB;

class TeamController extends Controller
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
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    function dashboard()
    {
        $teams = DB::table('teams')->where('nama', 'team 1')->get();
        // dd($teams);
        return view('dashboard.dashboard', compact('teams'));
    }

    function makeTeam(Request $request)
    {
        $namaTeam = $request->get('namaTeam');
        if ($namaTeam == '') {
            return response()->json(array(
                'msg' => 'Nama Team Harus Diisi!!!'
            ), 200);
        }

        $searchNama = DB::table('teams')
            ->where('nama', $namaTeam)
            ->get();
        if (count($searchNama) > 0) {
            return response()->json(array(
                'msg' => 'Nama Team Sudah Terpakai'
            ), 200);
        }
        DB::table('teams')
            ->insert([
                'nama' => $namaTeam,
                'dana' => 10000,
                'inventory' => 1000,
                'total_pendapatan' => 0,
                'demand' => 0,
                'customer_value' => 0,
                'hibah' => 0
            ]);
        $idteam = DB::getPdo()->lastInsertId();
        $idkomponen = 1;
        for ($jenisMesin = 1; $jenisMesin <= 7; $jenisMesin++) {
            DB::table('mesin_has_teams')
                ->insert([
                    'mesin_idmesin' => $jenisMesin,
                    'teams_idteam' => $idteam,
                    'level' => 1
                ]);
            DB::table('kapasitas_has_teams')
                ->insert([
                    'kapasitas_idkapasitas' => ((($jenisMesin - 1) * 5) + 1),
                    'kapasitas_mesin_idmesin' => $jenisMesin,
                    'teams_idteam' => $idteam
                ]);
            for ($komponen = 0; $komponen < 4; $komponen++) {
                DB::table('level_komponen')
                    ->insert([
                        'teams_idteam' => $idteam,
                        'komponen_idkomponen' => $idkomponen,
                        'komponen_mesin_idmesin' => $jenisMesin
                    ]);
                $idkomponen+=10;
            }
        }
    }
}
