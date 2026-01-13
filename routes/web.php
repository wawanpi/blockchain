<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Import Model ---
use App\Models\Menu; 

// --- Import Semua Controller ---
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController; 
use App\Http\Controllers\Customer\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE PUBLIK (BISA DIAKSES TAMU)
// ==========================================

// Landing Page
Route::get('/', function () {
    // Ambil menu terbaru beserta review-nya
    $menus = Menu::with('reviews')->latest()->get();
    return view('welcome', compact('menus'));
})->name('welcome');

// Halaman About
Route::get('/about', function () {
    return view('about');
})->name('about');


// ==========================================
// RUTE USER / PELANGGAN (LOGIN & TERVERIFIKASI)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard User (Menampilkan Menu)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang Belanja (Cart)
    Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove-cart', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('/clear-cart', [CartController::class, 'clearAllCart'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Riwayat Pesanan
    Route::get('/riwayat-pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/riwayat-pesanan/{pesanan}', [OrderController::class, 'show'])->name('orders.show');

    // Fitur Pesan Lagi (Reorder)
    Route::post('/riwayat-pesanan/{pesanan}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

    // Review / Ulasan Produk
    Route::get('/riwayat-pesanan/{pesanan}/review/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/riwayat-pesanan/{pesanan}/review', [ReviewController::class, 'store'])->name('reviews.store');
});


// ==========================================
// RUTE KHUSUS ADMIN (LOGIN, VERIFIED, ROLE:ADMIN)
// ==========================================
Route::middleware(['auth', 'verified', 'role:admin']) 
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Menu & Kuota
        Route::get('menus/{menu}/tambah-kuota', [MenuController::class, 'editKuota'])->name('menus.editKuota');
        Route::put('menus/{menu}/update-kuota', [MenuController::class, 'updateKuota'])->name('menus.updateKuota');
        Route::resource('menus', MenuController::class);

        // Manajemen User
        Route::resource('users', UserController::class);

        // Manajemen Pesanan
        Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::put('pesanan/{pesanan}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

        // Pesanan Offline & Tambah Item (Fitur Admin)
        Route::post('pesanan/store-offline', [PesananController::class, 'storeOffline'])->name('pesanan.storeOffline');
        Route::post('pesanan/{pesanan}/tambah-item', [PesananController::class, 'addItem'])->name('pesanan.addItem');

        // ==========================================================
        // Laporan & Transaksi (+ Fitur Blockchain Audit & Restore)
        // ==========================================================
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('transaksi/verifikasi/{pesanan}', [TransaksiController::class, 'verifikasi'])->name('transaksi.verifikasi');
        
        // [NEW] Rute untuk halaman Audit Integritas Blockchain
        Route::get('transaksi/{id}/audit', [TransaksiController::class, 'cekIntegritas'])->name('transaksi.audit');

        // [NEW] Rute untuk Memulihkan Data (Self-Healing) dari Snapshot
        Route::post('transaksi/{id}/restore', [TransaksiController::class, 'restoreData'])->name('transaksi.restore');
        
        Route::get('transaksi/cetak', [TransaksiController::class, 'cetakLaporan'])->name('transaksi.cetak');
});

// Rute Autentikasi (Breeze)
require __DIR__.'/auth.php';