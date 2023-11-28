<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;

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
// route tampil form kelas
// Route::get('/formKelas', [KelasController::class, 'formKelas']);
// route tampil edit kelas
// Route::get('/editKelas', [KelasController::class, 'editKelas']);
