<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataKaryawanController;
use App\Http\Controllers\DataKriteriaController;
use App\Http\Controllers\UserControlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'halaman_depan/index');
    Route::get('/sesi',[AuthController::class,'index'])->name('auth');
    Route::post('/sesi',[AuthController::class,'login']);
    Route::get('/reg',[AuthController::class,'create'])->name('registrasi');
    Route::post('/reg',[AuthController::class,'register']);
    Route::get('/verify/{verify_key}', [AuthController::class, 'verify']);
});


    //harus verifikasi dan login
    Route::middleware(['auth'])->group(function () {
    Route::redirect('/home','/user');
    Route::get('/admin',[AdminController::class,'index'])->name('admin');
    Route::get('/user',[UserController::class,'index'])->name('user');

    // Data Calon Karyawan
    Route::get('/datakaryawan',[DataKaryawanController::class,'index'])->name('datakaryawan');
    Route::get('/tambahdaka', [DataKaryawanController::class, 'tambah']);
    Route::post('/tambahdaka', [DataKaryawanController::class, 'create']);
    Route::get('/dakaedit/{id}',[DataKaryawanController::class,'edit']);
    Route::get('/dakahapus/{id}',[DataKaryawanController::class,'hapus']);
    Route::post('/editdaka', [DataKaryawanController::class, 'change']);
    Route::post('/uprole/{id}', [UproleController::class, 'index']);
    

    //User Control
    Route::get('/usercontrol',[UserControlController::class,'index'])->name('usercontrol');
    Route::get('/tambahuc', [UserControlController::class, 'tambah']);
    Route::post('/tambahuc', [UserControlController::class, 'create']);
    Route::get('/edituc/{id}', [UserControlController::class, 'edit']);
    Route::post('/hapusuc/{id}', [UserControlController::class, 'hapus']);
    Route::post('/edituc', [UserControlController::class, 'change']);
    Route::post('/uprole/{id}', [UproleController::class, 'index']);

    //Data Kriteria
    Route::get('/datakriteria', [DataKriteriaController::class, 'index'])->name('datakriteria');
    Route::get('/tambahkriteria', [DataKriteriaController::class, 'tambah']);
    Route::get('/editkriteria/{id}', [DataKriteriaController::class, 'edit']);
    Route::post('/tambahkriteria', [DataKriteriaController::class, 'create']);
    Route::post('/editkriteria', [DDataKriteriaController::class, 'change']);

    //Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});


