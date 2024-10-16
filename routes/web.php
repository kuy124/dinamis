<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DataTableController;

// LOGIN - LOGOUT
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// BUAT ADMIN
Route::middleware('auth')->group(function () {
    Route::delete('/tables/{table}', [DataTableController::class, 'destroy'])->name('tables.destroy');
    Route::delete('/records/{record}', [DataTableController::class, 'deleteRecord'])->name('records.delete');
    Route::get('/index', [DataTableController::class, 'index'])->name('tables.index');
    Route::get('/tables/create', [DataTableController::class, 'create'])->name('tables.create');
    Route::post('/tables', [DataTableController::class, 'store'])->name('tables.store');
    Route::get('/tables/{table}', [DataTableController::class, 'show'])->name('tables.show');
    Route::post('/tables/{table}/records', [DataTableController::class, 'addRecord'])->name('tables.add-record');
    Route::put('/records/{record}', [DataTableController::class, 'updateRecord'])->name('records.update');
});  

// BUAT USER
Route::get('/charts', [DataTableController::class, 'charts'])->name('charts');
Route::get('/kontak', [DataTableController::class, 'kontak'])->name('kontak');
Route::get('/', function () {
    return view('landing');
})->name('landing');
Route::get('/user', [DataTableController::class, 'user'])->name('user.user');
Route::get('/user/{table}', [DataTableController::class, 'showuser'])->name('user.show');