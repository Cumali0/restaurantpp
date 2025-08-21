<?php
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\ProfileController;


use App\Http\Controllers\Auth\RegisterController;

// Ana sayfa
Route::get('/', function () {
    return view('index');
})->name('home');


Route::get('/menu', [MenuController::class, 'index'])->name('menu.index'); // Tüm kategorileri göster
Route::get('/menu/{id}', [MenuController::class, 'categoryProducts'])->name('menu.products'); // Seçilen kategori ürünleri


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Admin sayfaları
Route::prefix('dashboard')->group(function() {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('dashboard.login');
    Route::post('login', [AdminController::class, 'login'])->name('dashboard.login.post');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::post('/reservation/resume', [ReservationController::class, 'resume'])
    ->name('reservation.resume');


Route::get('/profile', function() {
    return view('profile'); // resources/views/profile.blade.php olacak
})->name('profile')->middleware('auth'); // sadece giriş yapmış kullanıcılar görebilir



    Route::middleware('auth')->group(function () {

        Route::get('/my-reservations', [UserController::class, 'myReservations'])
            ->middleware('auth')
            ->name('user.resarvation');  // <-- Buradaki name önemli

        Route::get('/orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('auth')->name('orders.show');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });









    // ----------------------------
    // Middleware ile korunan admin paneli
    // ----------------------------
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            $recentReservations = \App\Models\Reservation::latest()->take(5)->get();
            return view('admin.index', compact('recentReservations'));
        })->name('dashboard');

        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        // diğer admin route'lar...
    });
});
