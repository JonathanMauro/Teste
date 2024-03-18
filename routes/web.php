<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoColaboradorController;

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
    return view('welcome');
});


Route::get('/ranking', function() {
    return view('ranking');
});

Route::get('/total', function() {
    return view('total');
});

Route::get('/edit/{id}', function() {
    return view('edit');
})->name('edit');






