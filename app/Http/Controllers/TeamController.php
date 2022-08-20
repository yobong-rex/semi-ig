<?php

namespace App\Http\Controllers;

use App\Events\Sesi;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;

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
        $team = Auth::user();
        $idteam = $team->teams_idteam;
        if ($team->teams_idteam == null) {
            if ($team->role == 'SI') {
                return redirect()->route('adminsesi');
            } else {
                return redirect()->route('market');
            }
        }

        $user = DB::table('teams')->select('nama', 'dana', 'idteam', 'inventory', 'demand', 'customer_value', 'hibah')->where('idteam', $team->teams_idteam)->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();
        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        $data = DB::table('team_demand')
            ->join('produk', 'team_demand.idproduk', 'produk.idproduk')
            ->where('idteam', $team->teams_idteam)
            ->where('sesi', $namaSesi)
            ->get();

        $bahanBaku = DB::table('ig_markets')->where('sesi', $namaSesi)->get();
        $bbTeam = DB::table('inventory')->where('teams', $team->teams_idteam)->get();

        $produk = DB::table('produk')->select('idproduk', 'nama')->get();

        $produk_team = DB::table('history_produksi')->where('teams_idteam', $team->teams_idteam)->where('sesi', $namaSesi)->get();

        $idanalisisProses = DB::table('analisis as a')
            ->join('teams_has_analisis as tha', 'a.idanalisis', '=', 'tha.analisis_idanalisis')
            ->select(DB::raw('MAX(a.idanalisis) as maxIdAnalisis'), 'produksi')
            ->where('tha.teams_idteam', $user[0]->idteam)
            ->groupBy('a.produksi')
            ->orderBy('a.idanalisis')
            ->get();

        $analisisProses = [];
        foreach ($idanalisisProses as $idAP) {
            $arrAP = DB::table('teams_has_analisis')
                ->select('maxProduct', 'cycleTime')
                ->where('analisis_idanalisis', $idAP->maxIdAnalisis)
                ->get();
            if ($idAP->produksi == 1) {
                $analisisProses[0] = array($idAP->produksi, $arrAP[0]->maxProduct, $arrAP[0]->cycleTime);
            }
            if ($idAP->produksi == 2) {
                $analisisProses[1] = array($idAP->produksi, $arrAP[0]->maxProduct, $arrAP[0]->cycleTime);
            }
            if ($idAP->produksi == 3) {
                $analisisProses[2] = array($idAP->produksi, $arrAP[0]->maxProduct, $arrAP[0]->cycleTime);
            }
        }
        
        return view('Dashboard.dashboard', compact('idteam', 'user', 'valueSesi', 'namaSesi', 'data', 'produk', 'bahanBaku', 'bbTeam', 'produk_team', 'analisisProses'));
    }

    function masukMakeTeam()
    {
        $team = Auth::user()->id;
        $user = DB::table('users')->select(DB::raw('name as nama'))->where('id', $team)->get();

        $getSesi = DB::table('sesi as s')
            ->join('waktu_sesi as ws', 's.sesi', '=', 'ws.idwaktu_sesi')
            ->select('s.sesi', 'ws.nama')
            ->get();

        $valueSesi = $getSesi[0]->sesi;
        $namaSesi = $getSesi[0]->nama;

        return view('maketeam', compact('user', 'namaSesi', 'valueSesi'));
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

        $mesin = DB::table('mesin')->get();

        DB::table('teams')
            ->insert([
                'nama' => $namaTeam,
                'dana' => 15000,
                'total_defect' => 0,
                'total_berhasil' => 0,
                'pengeluaran' => 0,
                'inventory' => 600,
                'total_pendapatan' => 0,
                'demand' => 0,
                'customer_value' => 0,
                'hibah' => 0,
                'over_production' => 0,
                'limit_produksi1' => 73,
                'limit_produksi2' => 79,
                'limit_produksi3' => 90
            ]);

        $idteam = DB::getPdo()->lastInsertId();
        $idkomponen = 1;

        for ($jenisMesin = 1; $jenisMesin <= 7; $jenisMesin++) {
            DB::table('mesin_has_teams')
                ->insert([
                    'mesin_idmesin' => $jenisMesin,
                    'teams_idteam' => $idteam,
                    'level' => 1,
                    'cycleTime' => $mesin[$jenisMesin - 1]->cycle
                ]);
            DB::table('kapasitas_has_teams')
                ->insert([
                    'kapasitas_idkapasitas' => ((($jenisMesin - 1) * 6) + 1),
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
                $idkomponen += 10;
            }
        }

        return response()->json(array(
            'msg' => 'berhasil'
        ), 200);
    }

    function overProduct(Request $request)
    {
        try {
            $team = Auth::user()->teams_idteam;
            $result = DB::table('teams')
                ->select('over_production')
                ->where('idteam', $team)->get()[0]->over_production;
            return response()->json(array(
                'result' => $result,
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'msg' => 'maaf ada kesalahan koneksi dengan server  ' . $e,
                'code' => '401'
            ), 200);
        }
    }

    function leaderboard()
    {
        $data1 = DB::table('teams')->select('nama', 'customer_value')->where('nama', '!=', 'SI')->orderBy('customer_value', 'desc')->get();
        // return view('leaderboard', compact('data1','data2'));
        return response()->json(array(
            'data1' => $data1,
        ), 200);
    }
}
