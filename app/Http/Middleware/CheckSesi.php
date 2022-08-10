<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

class CheckSesi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $checkSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        if($checkSesi[0]->nama == 'Cooldown'){
            return redirect('/');
        }
        if(($checkSesi[0]->nama == '2') ){
            if(Auth::user()->role == 'Production Manager'){
                return redirect('analisis');
            }
            else{
                return redirect('/');
            }
        }
        return $next($request);
    }
}
