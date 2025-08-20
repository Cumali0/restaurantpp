<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
return view('index');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index'); // Tüm kategorileri göster
Route::get('/menu/{id}', [MenuController::class, 'categoryProducts'])->name('menu.products'); // Seçilen kategori ürünleri
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
