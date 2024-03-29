<?php

namespace App\Http\Controllers;

use App\Mesin;
use App\Events\TestPusher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function show(Mesin $mesin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesin $mesin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesin $mesin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesin $mesin)
    {
        //
    }

    function cobaAjax()
    {
        $mesin = DB::table('mesin')->get();
        return response()->json(array(
            'mesin' => $mesin
        ), 200);
    }

    public function cobaPusher(Request $request)
    {
        $message = $request->get('message');

        event(new TestPusher($message));

        return ['success' => true];
    }
}
