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


Route::middleware(['auth'])->group(function(){
    // IG Market
    Route::get('/market','MarketController@market')->name('market');
    Route::post('/market/beli','MarketController@marketBeli')->name('market.beli');
});

// Dashboard
Route::get('/', 'TeamController@dashboard')->name('dashboard');


// Sesi Analisis
Route::get('/admin', function () {
    return view ('Sesi_Analisis.admin');
})->name('admin');

Route::get('/analisis', 'AnalisisController@analisi')->name('analisis');

Route::post('/analisis/proses','AnalisisController@insertProses')->name('analisis.proses');


// Analisis Bahan Baku
Route::get('/bahan', function () {
    return view ('Analisis_Bahan_Baku.bahan');
})->name('bahan');


//produksi
Route::get('/produksi','ProduksiController@produksi')->name('produksi');

Route::get('/prosesbahan', function () {
    return view ('Analisis_Bahan_Baku.prosesbahan');
})->name('prosesbahan');


// Mesin
Route::get('/komponen-mesin', function () {
    return view ('mesin.komponen');
})->name('komponenMesin');

Route::get('/kapasitas','KapasitasController@index')->name('kapasitas');

//Route coba-coba


Route::post('/coba', 'MesinController@coba')->name('coba');
// Route::get('/upgradeKomponen', 'MesinController')->name('upgrade');

Route::get('/admin/analisis','AnalisisController@admin')->name('analisis.admin');
Route::post('/admin/analisis/update','AnalisisController@updateSesi')->name('analisis.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/demand','DemandController@demand')->name('demand');
Route::post('/demand/konfrim','DemandController@konfrim')->name('demand.konfrim');

Route::get('/produksites', function () {
    return view ('produksi.produksites');
})->name('produksites');