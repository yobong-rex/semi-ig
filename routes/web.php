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

// route masukkan sini kalau sebelum masuk halaman web user harus login dahulu
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', 'TeamController@dashboard')->name('dashboard');
    Route::post('/dashboard/overProduct', 'TeamController@overProduct')->name('dashboard.overProduct');

    // Analisis Proses
    Route::get('/analisis', 'AnalisisController@analisi')->middleware('can:isProduction_Manager')->name('analisis');
    Route::post('/analisis/proses', 'AnalisisController@insertProses')->name('analisis.proses');

    Route::middleware([CheckSesi::class])->group(function () {
        // Mesin Kapasitas
        Route::get('/kapasitas', 'KapasitasController@kapasitas')->middleware('can:isProduction_Manager')->name('kapasitas');
        Route::post('/kapasitas/upgrade', 'KapasitasController@kapasitasUpgrade')->name('upgrade.kapasitas');

        // Mesin Komponen
        Route::get('/komponen', 'KomponenController@komponen')->middleware('can:isMarketing')->name('komponen');
        Route::get('/komponen/ajax', 'KomponenController@komponenAjax')->name('komponen.ajax');
        Route::post('/komponen/upgrade', 'KomponenController@komponenUpgrade')->name('upgrade.komponen');

        // Analisis Bahan Baku
        Route::get('/bahan', 'BahanController@bahan')->middleware('can:isResearcher')->name('bahan');
        Route::post('/bahan', 'BahanController@analisisBahan')->name('analisis.bahan');

        //produksi
        Route::get('/produksi', 'ProduksiController@produksi')->middleware('can:isProduction_Manager')->name('produksi');
        Route::post('/produksi/buat', 'ProduksiController@buat')->name('produksi.buat');

        //demand
        Route::get('/demand', 'DemandController@demand')->middleware('can:isMarketing')->name('demand');
        Route::post('/demand/konfrim', 'DemandController@konfrim')->name('demand.konfrim');
        Route::post('/demand/get', 'DemandController@getDemand')->name('demand.getDemand');
    });


    // IG Market
    Route::get('/market', 'MarketController@market')->middleware('can:isAdmin')->name('market');
    Route::post('/market/beli', 'MarketController@marketBeli')->name('market.beli');


    //admin analisis
    Route::get('/adminanalisis', 'AnalisisController@admin')->middleware('can:isAdmin')->name('analisis.admin');
    Route::post('/adminanalisis/update', 'AnalisisController@updateSesi')->name('analisis.update');


    // Admin Sesi
    Route::get('/adminsesi', 'SesiController@sesi')->middleware('can:isSI')->name('adminsesi');
    Route::post('/adminsesi/startsesi', 'SesiController@startSesi')->name('start.sesi');
    Route::post('/adminsesi/pausesesi', 'SesiController@pauseSesi')->name('pause.sesi');
    Route::post('/adminsesi/stopsesi', 'SesiController@stopSesi')->name('stop.sesi');
    Route::post('/adminsesi/gantisesi', 'SesiController@gantiSesi')->name('ganti.sesi');
    Route::post('/adminsesi/backsesi', 'SesiController@backSesi')->name('back.sesi');


    // MakeTeam
    Route::get('/maketeam', 'TeamController@masukMakeTeam')->middleware('can:isAdmin')->name('maketeam');
    Route::post('/maketeam/maketeam', 'TeamController@makeTeam')->name('makeTeam');

    //leaderboard
    Route::get('/leaderboard', function() {
        return view('leaderboard');
    })->name('leaderboard');
    Route::post('/leaderboard/data', 'TeamController@leaderboard')->name('leaderboard');
});



// Sesi Analisis
Route::get('/admin', function () {
    return view('Sesi_Analisis.admin');
})->name('admin');


Route::get('/prosesbahan', function () {
    return view('Analisis_Bahan_Baku.prosesbahan');
})->name('prosesbahan');


// Timer
route::post('/timer', 'SesiController@timer')->name('timer');


//Route coba-coba
Route::post('/ajax', 'MesinController@cobaAjax')->name('coba.ajax');
Route::post('/pusher', 'MesinController@cobaPusher')->name('coba.pusher');

Route::get('/sender', function () {
    return view('senderPusher');
})->name('sender');

Route::get('/receiver', function () {
    return view('receiverPusher');
})->name('receiver');

Route::get('/test/timer', function () {
    return view('testTimer');
})->name('test.timer');
//Route coba-coba


// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
