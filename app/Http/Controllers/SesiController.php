<?php

namespace App\Http\Controllers;

use App\Events\Sesi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class SesiController extends Controller
{
    function sesi()
    {
        $sesi = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();
        return view('adminsesi', compact('sesi'));
    }

    function gantiSesi(Request $request)
    {
        $sekarang = $request->get('sesi');

        $upSesi = $sekarang + 1;
        if ($sekarang == 6) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Max Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($upSesi)]);
        }

        $updated = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();

        $team = DB::table('teams')
            ->select('idteam', 'dana', 'hibah','total_pendapatan')
            ->get();

        if ($upSesi == 3) {
            foreach ($team as $t) {
                $dblDana = (float)$t->dana;
                $danaPlus = ($dblDana) + ($t->hibah);
                $hibahBaru = ($t->hibah) - ($t->hibah);
                $danaBaru = (int)floor($danaPlus);
                DB::table('teams')
                    ->where('idteam', $t->idteam)
                    ->update([
                        'dana' => ($danaBaru),
                        'hibah' => ($hibahBaru)
                    ]);
            }
        }

        foreach ($team as $t){
            $overProd = DB::table('history_produksi')->where('teams_idteam',$t->idteam)->where('sesi', $sekarang)->where('hasil','>',0)->get();
            $temp = 0;
            if(count($overProd)>0){
                foreach ($overProd as $op){
                    $hargaProduk = DB::table('produk')->select('harga_jual')->where('idproduk',$op->produk_idproduk)->get();
                    $temp += ($op->hasil * floor($hargaProduk[0]->harga_jual * 40 /100)); 
                }
                $danaBaru = $t->dana + $temp;
                $totalPendapatanBaru = $t->total_pendapatan + $temp;
    
                DB::table('teams')->where('idteam', $t->idteam)->update(['dana'=>$danaBaru, 'total_pendapatan'=>$totalPendapatanBaru]);
            }
        }

        $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi = $getSesi[0]->nama;

        event(new Sesi($sesi));

        return response()->json(array(
            "success"=>true,
            'sesi' => $sesi
        ), 200);
    }

    function backSesi(Request $request)
    {
        $sekarang = $request->get('sesi');

        if ($sekarang == 1) {
            return response()->json(array(
                'msg' => 'Sesi Sudah Gabisa Kurang Woe!!'
            ), 200);
        } else {
            DB::table('sesi')
                ->where('idsesi', 1)
                ->update(['sesi' => ($sekarang - 1)]);
        }

        $updated = DB::table('sesi')
            ->where('idsesi', 1)
            ->get();

       
            $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
            $sesi = $getSesi[0]->nama;
    
            event(new Sesi($sesi));
    
            return response()->json(array(
                "success"=>true,
                'sesi' => $sesi
            ), 200);
    }

    public function getSesi(Request $request){
        
        $getSesi = DB::table('sesi')->join('waktu_sesi', 'sesi.sesi', '=', 'waktu_sesi.idwaktu_sesi')->select('waktu_sesi.nama')->get();
        $sesi = $getSesi[0]->nama;
        return response()->json(array(
            'sesi' => $sesi
        ), 200);
    }
}
