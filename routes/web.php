<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PerjanjianKreditController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('surat/export', [SuratController::class, 'export'])->name('surat.export');
    Route::resource('surat', SuratController::class);
    Route::get('invoice/export', [InvoiceController::class, 'export'])->name('invoice.export');
    Route::resource('invoice', InvoiceController::class);
    Route::get('perjanjian-kredit/export', [PerjanjianKreditController::class, 'export'])->name('perjanjian-kredit.export');
    Route::resource('perjanjian-kredit', PerjanjianKreditController::class);

    // User Management (Admin Only)
    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
