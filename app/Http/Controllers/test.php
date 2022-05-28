<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class test extends Controller
{
    public function test123(){
        $data2 = 5;
        // return view('permisi',compact('data2'));
        return view('permisi',['data1'=>$data2]);
    }
}
