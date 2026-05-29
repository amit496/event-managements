<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AvenueController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventPaymentController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event:slug}', [HomeController::class, 'show'])->name('events.show');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('avenues', AvenueController::class);
        Route::resource('events', EventController::class);
        Route::resource('payments', EventPaymentController::class)->except(['create', 'show', 'edit']);
        Route::resource('clients', ClientController::class)->except(['create', 'show', 'edit']);
        Route::resource('bookings', BookingController::class)->except(['create', 'show', 'edit']);
        Route::resource('quotations', QuotationController::class)->except(['create', 'show', 'edit']);
        Route::resource('tasks', TaskController::class)->except(['create', 'show', 'edit']);
        Route::resource('vendors', VendorController::class)->except(['create', 'show', 'edit']);
        Route::resource('services', ServiceController::class)->except(['create', 'show', 'edit']);
        Route::resource('users', UserController::class)->except(['create', 'edit']);
        Route::resource('roles', RoleController::class)->except(['create', 'edit']);
        Route::resource('permissions', PermissionController::class)->except(['create', 'edit']);

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::patch('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.status');
        Route::patch('avenues/{avenue}/status', [AvenueController::class, 'updateStatus'])->name('avenues.status');
        Route::patch('events/{event}/status', [EventController::class, 'updateStatus'])->name('events.status');
        Route::patch('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
    });
});

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
