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
    return view ('sesi analisis.admin');
})->name('admin');

Route::get('/analisis', function () {
    return view ('sesi analisis.analisis');
})->name('analisis');



// Analisis Bahan Baku
Route::get('/bahan', function () {
    return view ('Analisis_Bahan_Baku.bahan');
})->name('bahan');

//prduksi
Route::get('/produksi', function () {
    return view ('produksi.produksi');
})->name('produksi');

Route::get('/prosesbahan', function () {
    return view ('Analisis_Bahan_Baku.prosesbahan');
})->name('prosesbahan');

// Mesin
Route::get('/komponen-mesin', function () {
    return view ('mesin.komponen');
})->name('komponenMesin');

Route::get('/kapasitas','KapasitasController@index')->name('kapasitas');

//Route coba-coba
Route::resource('team', 'TeamController');
Route::resource('mesin', 'MesinController');
Route::resource('komponen', 'KomponenController');
Route::resource('kapasitas', 'KapasitasController');

Route::post('/coba', 'MesinController@coba')->name('coba');
// Route::get('/upgradeKomponen', 'MesinController')->name('upgrade');

Route::get('/admin/analisis','AnalisisController@admin')->name('analisis.admin');
Route::post('/admin/analisis/update','AnalisisController@updateSesi')->name('analisis.update');

Route::get('/home', 'HomeController@index')->name('home');
