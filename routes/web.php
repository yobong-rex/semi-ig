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
Route::get('/market', function () {
    return view ('market');
})->name('market');

// Analisis Bahan Baku
Route::get('/bahan', function () {
    return view ('analisis bahan baku.bahan');
})->name('bahan');

Route::get('/prosesbahan', function () {
    return view ('analisis bahan baku.prosesbahan');
})->name('prosesbahan');

// Mesin
<<<<<<< Updated upstream
Route::get('/komponen-mesin', function () {
    return view ('Mesin.komponen');
})->name('komponenMesin');
=======
Route::get('/komponen', function () {
    return view ('mesin.komponen');
})->name('komponen');
>>>>>>> Stashed changes

Route::get('/kapasitas', function () {
    return view ('mesin.kapasitas');
})->name('kapasitas');

//Route Controller
Route::resource('team', 'TeamController');
Route::resource('mesin', 'MesinController');
Route::resource('komponen', 'KomponenController');
Route::resource('kapasitas', 'KapasitasController');