<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('login');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/data', [DataController::class, 'data']);
    Route::post('/insertdata', [DataController::class, 'insertData'])->name('insertdata');
    Route::get('/editdata/{id}', [DataController::class, 'editData'])->name('editdata');
    Route::post('/updatedata/{id}', [DataController::class, 'updateData'])->name('updatedata');
    Route::get('/insert', [DataController::class, 'insert'])->name('insert');
    Route::delete('/deletedata/{id}', [DataController::class, 'delete'])->name('deletedata');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/relasi/create', [HomeController::class, 'create'])->name('relasi.create');
    Route::post('/relasi/destinations', [HomeController::class, 'getDestinations'])->name('relasi.destinations');
    Route::post('/relasi/vehicles', [HomeController::class, 'getVehicles'])->name('relasi.vehicles');
    Route::post('/relasi/store', [HomeController::class, 'store'])->name('relasi.store');
});
