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

// Route::get('/', function () {
//     return view('');
// })->name('');

// Dashboard
Route::get('/', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

// Sesi Analisis
Route::get('/admin', function () {
    return view ('sesi analisis.admin');
})->name('admin');

Route::get('/analisis', function () {
    return view ('sesi analisis.analisis');
})->name('analisis');

// IG Market
Route::get('/market','MarketController@market')->name('market');
Route::post('/market/beli','MarketController@marketBeli')->name('market.beli');

// Analisis Bahan Baku
Route::get('/bahan', function () {
    return view ('analisis bahan baku.bahan');
})->name('bahan');

//prduksi
Route::get('/produksi', function () {
    return view ('produksi.produksi');
})->name('produksi');

Route::get('/prosesbahan', function () {
    return view ('analisis bahan baku.prosesbahan');
})->name('prosesbahan');

// Mesin
Route::get('/komponen-mesin', function () {
    return view ('mesin.komponen');
})->name('komponenMesin');

Route::get('/kapasitas', function () {
    return view ('mesin.kapasitas');
})->name('kapasitas');

//Route coba-coba
Route::resource('team', 'TeamController');
Route::resource('mesin', 'MesinController');
Route::resource('komponen', 'KomponenController');
Route::resource('kapasitas', 'KapasitasController');

Route::post('/coba', 'MesinController@coba')->name('coba');
Route::post('/konfirmasi_1', 'AnalisisController@insert')->name('konfirmasi_1');
Route::post('/konfirmasi_2', 'AnalisisController@insert')->name('konfirmasi_2');
Route::post('/konfirmasi_3', 'AnalisisController@insert')->name('konfirmasi_3');

Route::get('/admin/analisis','AnalisisController@admin')->name('analisis.admin');
Route::post('/admin/analisis/update','AnalisisController@updateSesi')->name('analisis.update');