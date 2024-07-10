<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/proses-login', [LoginController::class, 'proses_login'])->name('proses-login');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'role:admin,user']], function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');
    Route::get('/barang_masuk', function () {
        return view('pages.barang_masuk');
    })->name('barang_masuk');
    Route::get('/barang_keluar', function () {
        return view('pages.barang_keluar');
    })->name('barang_keluar');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin'], 'as' => 'admin.'], function () {
    Route::get('/user', function () {
        return view('pages.user');
    })->name('user');
    Route::get('/kategori', function () {
        return view('pages.kategori');
    })->name('kategori');
    Route::get('/barang', function () {
        return view('pages.barang');
    })->name('barang');
});