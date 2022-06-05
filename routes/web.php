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
    return view('Dashboard/dashboard');
})->name('dashboard');

// Sesi Analisis
Route::get('/admin', function () {
    return view ('/Sesi Analisis/admin');
})->name('admin');

Route::get('/analisis', function () {
    return view ('/Sesi Analisis/analisis');
})->name('analisis');

// IG Market
Route::get('/market', function () {
    return view ('market');
})->name('market');

// Analisis Bahan Baku
Route::get('/bahan', function () {
    return view ('/Analisis Bahan Baku/bahan');
})->name('bahan');

// Mesin
Route::get('/komponen', function () {
    return view ('/Mesin/komponen');
})->name('komponen');

Route::get('/kapasitas', function () {
    return view ('/Mesin/kapasitas');
})->name('kapasitas');