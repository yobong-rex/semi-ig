<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/12345678', function () {
    return view ('admin');
});

Route::view('/permisi','permisi');

Route::get('/test','test@test123')->name('test');

Route::get('/bbb/{a}',function($a){
    return $a;
});

Route::get('/aaa/{a?}',function($a='punten'){
    if($a === 'gopud'){
        return view('welcome');
    }
    else{
        return 'b';
    }
});