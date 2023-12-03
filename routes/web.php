<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MataPelajaranController;

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
//     return view('welcome');
// });
Route::get('/home', function () {
    return view('home',[
        "title" => "Home"
    ]);
});

// route tampil tabel kelas
Route::resource('/kelas', KelasController::class);
// route crud departemen
Route::resource('/department', DepartmentController::class);
// route crud guru
Route::resource('/guru', GuruController::class);
// route crud mata pelajaran
Route::resource('/matpel', MataPelajaranController::class);

