<?php

use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserListingController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [ListingController::class, 'index'])->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Listings Routes
    Route::prefix('listings')->name('listings.')->group(function () {
        Route::get('/', [UserListingController::class, 'index'])->name('index');
        Route::get('create', [UserListingController::class, 'create'])->name('create');
        Route::post('/', [UserListingController::class, 'store'])->name('store');
        Route::get('{listing}/edit', [UserListingController::class, 'edit'])->name('edit');
        Route::put('{listing}', [UserListingController::class, 'update'])->name('update');
        Route::delete('{listing}', [UserListingController::class, 'destroy'])->name('destroy');
    });

    // User Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Public Listing Show Route
Route::get('/listings/{listing}', [ListingController::class, 'show'])
    ->where('listing', '[0-9]+')
    ->name('listings.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});
