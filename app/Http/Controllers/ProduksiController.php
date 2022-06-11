<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProduksiController extends Controller
{
    function produksi(){
        $user = DB::table('teams')->select('nama','dana','idteam')->where('idteam',1)->get();
        $sesi = DB::table('sesi')->select('sesi')->get();
        $proses1 ='';
        $proses2 ='';
        $proses3 ='';
    
        if($sesi[0]->sesi == 1){
            $proses1 ='Sorting;Cutting;Bending;Assembling;Delay;Cutting;Assembling;Sorting;Packing';
            $proses2 ='Sorting;Cutting;Assembling;Drilling;Delay;Cutting;Assembling;Idle;Packing';
            $proses3 ='Sorting;Molding;Idle;Assembling;Sorting;Delay;Assembling;Packing;';
        }
        else{
            $proses1 = DB::table('teams_has_analisis')
                ->join('analisis','teams_has_analisis.analisis_idanalisis','=','analisis.idanalisis')
                ->select('teams_has_analisis.proses')->where('teams_has_analisis.teams_idteam',1)
                ->where('analisis.produksi',1)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses2 = DB::table('teams_has_analisis')
                ->join('analisis','teams_has_analisis.analisis_idanalisis','=','analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam',1)
                ->where('analisis.produksi',2)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            $proses3 = DB::table('teams_has_analisis')
                ->join('analisis','teams_has_analisis.analisis_idanalisis','=','analisis.idanalisis')
                ->select('teams_has_analisis.proses')
                ->where('teams_has_analisis.teams_idteam',1)
                ->where('analisis.produksi',3)
                ->orderBy('teams_has_analisis.analisis_idanalisis', 'desc')
                ->limit(1)->get();
            
            $proses1 = $proses1[0]->proses;
            $proses2 = $proses2[0]->proses;
            $proses3 = $proses3[0]->proses;
        }
    
        $splitProses1 = explode(';',$proses1);
        $splitProses2 = explode(';',$proses2);
        $splitProses3 = explode(';',$proses3);

    
        return view('Produksi.produksi',compact('splitProses1','splitProses2','splitProses3','user','sesi'));  
    }
}
