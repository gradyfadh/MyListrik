<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\PelangganDashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TarifController;
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

// 💡 Halaman landing dan info umum
Route::view('/', 'landing.landing-page')->name('landing-page');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    

    // New pelanggan auth routes (menggunakan PelangganAuthController)
    Route::get('/pelanggan/login', [PelangganAuthController::class, 'showLogin'])->name('pelanggan.login');
    Route::post('/pelanggan/login', [PelangganAuthController::class, 'login'])->name('pelanggan.login.attempt');
    Route::get('/pelanggan/register', [PelangganAuthController::class, 'showRegister'])->name('pelanggan.register.form');
    Route::post('/pelanggan/register', [PelangganAuthController::class, 'register'])->name('pelanggan.register.post');
});

// Auth logout (available for all authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/pelanggan/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

// Public pelanggan routes (without middleware for general access)
Route::get('/pelanggan/tarif-listrik', [TarifController::class, 'showToPelanggan'])->name('tarif.listrik.pelanggan');

// Pelanggan dashboard route (accessible after login - outside middleware for initial redirect)
Route::get('/pelanggan', function() {
    // Check if user is logged in as pelanggan
    if (session('logged_in') && session('level') == 2) {
        return view('pelanggan.index');
    }
    return redirect()->route('pelanggan.login');
})->name('pelanggan.index');

// 🔐 Admin Routes (Level 1)
Route::middleware('level:1')->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    // Konfirmasi pelanggan
    Route::get('/konfirmasi-pelanggan', [PelangganController::class, 'konfirmasiList'])->name('admin.pelanggan.konfirmasi');
    Route::post('/konfirmasi-pelanggan/{id}', [PelangganController::class, 'konfirmasi'])->name('admin.konfirmasi.submit');

    // Pelanggan management
    Route::prefix('pelanggan')->name('admin.pelanggan.')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::get('/create', [PelangganController::class, 'create'])->name('create');
        Route::post('/store', [PelangganController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PelangganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PelangganController::class, 'update'])->name('update');
        Route::post('/{id}/reset-password', [PelangganController::class, 'resetPassword'])->name('reset-password');
        Route::delete('/{id}', [PelangganController::class, 'destroy'])->name('destroy');
    });

    // Penggunaan management
    Route::prefix('penggunaan')->name('admin.penggunaan.')->group(function () {
        Route::get('/', [PenggunaanController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaanController::class, 'create'])->name('create');
        Route::post('/store', [PenggunaanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PenggunaanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PenggunaanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PenggunaanController::class, 'destroy'])->name('destroy');
    });

    // Tagihan management
    Route::prefix('tagihan')->name('admin.tagihan.')->group(function () {
        Route::get('/', [TagihanController::class, 'index'])->name('index');
        Route::post('/{id}/konfirmasi', [TagihanController::class, 'konfirmasi'])->name('konfirmasi');
        Route::get('/export/pdf', [TagihanController::class, 'exportPdf'])->name('exportPdf');
        Route::get('/{id}/bayar', [TagihanController::class, 'bayar'])->name('bayar');
        Route::delete('/{id}', [TagihanController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/preview', [TagihanController::class, 'preview'])->name('preview');
        Route::get('/{id}/print', [TagihanController::class, 'print'])->name('print');
    });

    // Pembayaran management
    Route::prefix('pembayaran')->name('admin.pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::post('/{id}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('verif');
        Route::get('/{id}/download', [PembayaranController::class, 'downloadBukti'])->name('download');
    });

    // Tarif management
    Route::resource('tarif', TarifController::class)->except(['show']);

    // Profile management
    Route::prefix('profile')->name('admin.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // Metode Pembayaran management (moved from outside middleware)
    Route::prefix('metode')->name('metode.')->group(function () {
        Route::get('/', [\App\Http\Controllers\MetodeController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\MetodeController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\MetodeController::class, 'store'])->name('store');
        Route::get('/{metode}', [\App\Http\Controllers\MetodeController::class, 'show'])->name('show');
        Route::get('/{metode}/edit', [\App\Http\Controllers\MetodeController::class, 'edit'])->name('edit');
        Route::put('/{metode}', [\App\Http\Controllers\MetodeController::class, 'update'])->name('update');
        Route::delete('/{metode}', [\App\Http\Controllers\MetodeController::class, 'destroy'])->name('destroy');
        Route::patch('/{metode}/toggle-status', [\App\Http\Controllers\MetodeController::class, 'toggleStatus'])->name('toggle-status');
    });
});

// 🔐 Pelanggan Routes (Level 2)
Route::middleware('level:2')->prefix('pelanggan')->group(function () {
    // Protected Dashboard route
    Route::view('/dashboard', 'pelanggan.index')->name('pelanggan.dashboard');

    // Tagihan
    Route::get('/tagihan', [TagihanController::class, 'pelangganIndex'])->name('pelanggan.tagihan');
    Route::get('/tagihan/{id}/struk', [TagihanController::class, 'strukPelanggan'])->name('tagihan.struk');

    // Pembayaran
    Route::get('/tagihan/{id}/bayar', [PembayaranController::class, 'create'])->name('bayar.create');
    Route::get('/tagihan/{id}/metode-pembayaran', [PembayaranController::class, 'metodePembayaran'])->name('bayar.metode');
    Route::post('/tagihan/{id}/bayar', [PembayaranController::class, 'store'])->name('bayar.store');
    Route::get('/riwayat-pembayaran', [PembayaranController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');
    Route::get('/pembayaran/{id}/download-bukti', [PembayaranController::class, 'downloadBukti'])->name('pembayaran.download-bukti');
    Route::get('/pembayaran/{id}/print-struk', [PembayaranController::class, 'printStruk'])->name('pembayaran.print-struk');

    // Riwayat penggunaan
    Route::get('/riwayat-penggunaan', [PelangganDashboardController::class, 'riwayatPenggunaan'])->name('riwayat-penggunaan');

    // Additional pelanggan routes (moved from legacy section)
    Route::get('/pembayaran', function() {
        return view('pelanggan.pembayaran.index');
    })->name('pembayaran');
});

// Legacy route removed - now using the main pelanggan.index route above
