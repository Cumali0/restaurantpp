<?php
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;



use App\Http\Controllers\Auth\RegisterController;

// Ana sayfa
Route::get('/', function () {
    return view('index');
})->name('home');




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




Route::middleware('auth')->group(function () {
    Route::get('/dashboard/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::delete('/dashboard/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/dashboard/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/dashboard/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
});

Route::get('/rezervasyon-tesekkurler', function () {
    return view('thankyou');
})->name('reservation.thankyou');

Route::post('/reservation/public', [ReservationController::class, 'storePublic'])
    ->name('reservations.store.public');

Route::get('/tables-availability', [ReservationController::class, 'tablesAvailability'])->name('tables.availability');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class)->except(['create', 'edit', 'show']);

});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class)->except(['create', 'edit', 'show']);

    Route::get('/tables/{tableId}/reservations', [App\Http\Controllers\Admin\TableController::class, 'getReservations'])
        ->name('tables.reservations');
});


Route::get('/admin/tables', [App\Http\Controllers\Admin\TableController::class, 'index'])->name('tables.index');









// Public rezervasyon formu
Route::get('/reservation', [ReservationController::class, 'showReservationForm'])->name('reservation.form');
Route::post('/reservation', [ReservationController::class, 'storePublic'])->name('reservation.storePublic');

// Admin rezervasyon yönetimi
Route::prefix('admin')->group(function () {
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::post('reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // AJAX: masa uygunluğu
    Route::get('tables-availability', [ReservationController::class, 'tablesAvailability'])->name('tables.availability');

    // Analitik
    Route::get('analytics', [ReservationController::class, 'analytics'])->name('analytics.index');

    // Token yönetimi
    Route::post('reservation/abandon/{reservation}', [ReservationController::class, 'abandonCart'])->name('reservation.abandonCart');
    Route::post('reservation/generate-token', [ReservationController::class, 'generateNewToken'])->name('reservation.generateNewToken');
});

// AJAX: Sepet içeriği alma
Route::get('reservation/preorder/{token}/cart', [ReservationController::class, 'getCart'])->name('reservation.getCart');




Route::prefix('admin')->name('admin.')->group(function () {
    // Kategori listeleme
    Route::resource('categories', CategoryController::class)->only(['index']);

    // Ürünler (tek sayfa CRUD)
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Menü sayfası: tüm kategoriler
Route::get('/menu', [ProductController::class, 'showMenu'])->name('menu.index');

// Seçilen kategoriye ait ürünler
Route::get('/menu/{id}', [ProductController::class, 'categoryProducts'])->name('menu.products');
