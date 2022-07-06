<?php

use App\Komponen;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSesi;

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


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', 'TeamController@dashboard')->name('dashboard');
    Route::middleware([CheckSesi::class])->group(function(){
        // Mesin Kapasitas
        Route::get('/kapasitas', 'KapasitasController@kapasitas')->name('kapasitas');
        Route::post('/kapasitas/upgrade', 'KapasitasController@kapasitasUpgrade')->name('upgrade.kapasitas');

        // Mesin Komponen
        Route::get('/komponen', 'KomponenController@komponen')->name('komponen');
        Route::get('/komponen/ajax', 'KomponenController@komponenAjax')->name('komponen.ajax');
        Route::post('/komponen/upgrade', 'KomponenController@komponenUpgrade')->name('upgrade.komponen');

        // Analisis Proses
        Route::get('/analisis', 'AnalisisController@analisi')->name('analisis');
        Route::post('/analisis/proses', 'AnalisisController@insertProses')->name('analisis.proses');
        
        // Analisis Bahan Baku
        Route::get('/bahan', 'BahanController@bahan')->name('bahan');
        Route::post('/bahan', 'BahanController@analisisBahan')->name('analisis.bahan');
    });



});


// IG Market
Route::get('/market', 'MarketController@market')->name('market');
Route::post('/market/beli', 'MarketController@marketBeli')->name('market.beli');

// Sesi Analisis
Route::get('/admin', function () {
    return view('Sesi_Analisis.admin');
})->name('admin');

//produksi
Route::get('/produksi', 'ProduksiController@produksi')->name('produksi');
Route::post('/produksi/buat', 'ProduksiController@buat')->name('produksi.buat');

Route::get('/prosesbahan', function () {
    return view('Analisis_Bahan_Baku.prosesbahan');
})->name('prosesbahan');

// Ganti Sesi
Route::get('/adminsesi', 'SesiController@sesi')->name('adminsesi');
Route::post('/adminsesi/gantisesi', 'SesiController@gantiSesi')->name('ganti.sesi');
Route::post('/adminsesi/backsesi', 'SesiController@backSesi')->name('back.sesi');


// Mesin
// Route::get('/komponen-mesin', function () {
//     return view ('mesin.komponen');
// })->name('komponenMesin');

//Route coba-coba
Route::post('/coba', 'MesinController@coba')->name('coba');
// Route::get('/upgradeKomponen', 'MesinController')->name('upgrade');

Route::get('/admin/analisis', 'AnalisisController@admin')->name('analisis.admin');
Route::post('/admin/analisis/update', 'AnalisisController@updateSesi')->name('analisis.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/demand', 'DemandController@demand')->name('demand');
Route::post('/demand/konfrim', 'DemandController@konfrim')->name('demand.konfrim');
Route::post('/demand/get', 'DemandController@getDemand')->name('demand.getDemand');

// Route::get('/komponentes', 'KomponenController@komponen')->name('komponestes');

Route::get('/adminkomponen', function () {
    return view('mesin.adminkomponen');
})->name('adminkomponen');
// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/maketeam', function () {
    return view('maketeam');
})->name('maketeam');

Route::post('/maketeam/maketeam', 'TeamController@makeTeam')->name('makeTeam');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
