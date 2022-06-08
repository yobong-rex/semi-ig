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

        // return view('mesin.kapasitas', compact('kapasitas'));
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
}
