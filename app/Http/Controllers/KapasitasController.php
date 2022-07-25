<?php

namespace App\Http\Controllers;

use App\Kapasitas;
use App\Events\Mesin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        // $idkap = DB::table('kapasitas_has_teams as kht')
        //     ->join('kapasitas as k', 'kht.kapasitas_idkapasitas', '=', 'k.idkapasitas')
        //     ->select('kht.kapasitas_idkapasitas', 'k.level', 'k.harga')
        //     ->where('kht.teams_idteam', $user[0]->idteam)
        //     ->where('kht.kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
        //     ->get();

        // $upgrade = $idkap[0]->kapasitas_idkapasitas;
        // $level = $idkap[0]->level;
        // $dana = $user[0]->dana;
        // $harga = $idkap[0]->harga;

        // if ($level < 5) {
        //     if ($dana >= $harga) {
        //         $upgrade += 1;
        //         DB::table('kapasitas_has_teams')
        //             ->where('teams_idteam', $user[0]->idteam)
        //             ->where('kapasitas_mesin_idmesin', $idmesin[0]->idmesin)
        //             ->update(['kapasitas_idkapasitas' => $upgrade]);

        //         DB::table('teams')
        //             ->where('idteam', $user[0]->idteam)
        //             ->update(['dana' => ($dana - $harga)]);
        //     } else {
        //         return response()->json(array(
        //             'msg' => 'Dana Tidak Mencukupi'
        //         ), 200);
        //     }
        // } else {
        //     return response()->json(array(
        //         'msg' => 'Level Maxed'
        //     ), 200);
        // }

        $updatedUser = DB::table('teams')->select('dana')->where('idteam', $user[0]->idteam)->get();

        $data = DB::table('mesin as m')
            ->join('kapasitas as k', 'm.idmesin', '=', 'k.mesin_idmesin')
            ->join('kapasitas_has_teams as kht', 'k.idkapasitas', '=', 'kht.kapasitas_idkapasitas')
            ->select('m.nama', 'k.level', 'k.kapasitas')
            ->where('kht.teams_idteam', $user[0]->idteam)
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

        $arrKapasitas1 = [];
        $arrKapasitas2 = [];
        $arrKapasitas3 = [];

        // start (ambil kapasitas)
            if (count($produksi1) != 0) {
                $proses1 = explode(';', $produksi1[0]->proses);

                for ($x = 0; $x < $idProduksi1[0]->length; $x++) {
                    $kapasitas1 =  DB::table('kapasitas_has_teams as kht')
                        ->join('kapasitas as k', 'kht.kapasitas_idkapasitas', '=', 'k.idkapasitas')
                        ->join('mesin as m', 'kht.kapasitas_mesin_idmesin', '=', 'm.idmesin')
                        ->select(DB::raw('k.kapasitas as kapasitas'))
                        ->where('kht.teams_idteam', '=', $user[0]->idteam)
                        ->where('m.nama', 'like', '%' . $proses1[$x] . '%')
                        ->get();

                    array_push($arrKapasitas1, $kapasitas1[0]->kapasitas);
                }
            }

            if (count($produksi2) != 0) {
                $proses2 = explode(';', $produksi2[0]->proses);

                for ($x = 0; $x < $idProduksi2[0]->length; $x++) {
                    $kapasitas2 =  DB::table('kapasitas_has_teams as kht')
                        ->join('kapasitas as k', 'kht.kapasitas_idkapasitas', '=', 'k.idkapasitas')
                        ->join('mesin as m', 'kht.kapasitas_mesin_idmesin', '=', 'm.idmesin')
                        ->select(DB::raw('k.kapasitas as kapasitas'))
                        ->where('kht.teams_idteam', '=', $user[0]->idteam)
                        ->where('m.nama', 'like', '%' . $proses2[$x] . '%')
                        ->get();

                    array_push($arrKapasitas2, $kapasitas2[0]->kapasitas);
                }
            }

            if (count($produksi3) != 0) {
                $proses3 = explode(';', $produksi3[0]->proses);

                for ($x = 0; $x < $idProduksi3[0]->length; $x++) {
                    $kapasitas3 =  DB::table('kapasitas_has_teams as kht')
                        ->join('kapasitas as k', 'kht.kapasitas_idkapasitas', '=', 'k.idkapasitas')
                        ->join('mesin as m', 'kht.kapasitas_mesin_idmesin', '=', 'm.idmesin')
                        ->select(DB::raw('k.kapasitas as kapasitas'))
                        ->where('kht.teams_idteam', '=', $user[0]->idteam)
                        ->where('m.nama', 'like', '%' . $proses3[$x] . '%')
                        ->get();

                    array_push($arrKapasitas3, $kapasitas3[0]->kapasitas);
                }
            }
        // end (ambil kapasitas)

        // cari kapasitas terkecil
        $minKpasitas1 = min($arrKapasitas1);
        $minKpasitas2 = min($arrKapasitas2);
        $minKpasitas3 = min($arrKapasitas3);

        // event(new Mesin('kapasitas', 'cycle'));

        return response()->json(array(
            'data' => $data,
            'user' => $updatedUser,
            'msg' => 'Upgrade Successful'
        ), 200);
    }
}
