<?php

use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserListingController;
use App\Http\Controllers\User\ApplicationController;
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
    // User hanya bisa create listing baru
    Route::get('/listings/create', [UserListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [UserListingController::class, 'store'])->name('listings.store');

    // Application Routes untuk User (HANYA USER)
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('my-applications');
        Route::get('{listing}/create', [ApplicationController::class, 'create'])->name('create');
        Route::post('{listing}', [ApplicationController::class, 'store'])->name('store');
        Route::get('{application}', [ApplicationController::class, 'show'])->name('show');
        Route::get('{application}/download-resume', [ApplicationController::class, 'downloadResume'])->name('download-resume');
        Route::delete('{application}', [ApplicationController::class, 'destroy'])->name('destroy');
    });

    // User Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Public Listing Show Route - Only approved listings
Route::get('/listings/{listing}', [ListingController::class, 'show'])
    ->where('listing', '[0-9]+')
    ->name('listings.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========== ADMIN APPLICATION MANAGEMENT ROUTES ==========
    // Manage Applications (sekarang utama di listings)
    Route::prefix('listings')->name('listings.')->group(function () {
        Route::get('/', [AdminListingController::class, 'index'])->name('index'); // Sekarang menampilkan applications
        Route::get('/create', [AdminListingController::class, 'create'])->name('create');
        Route::post('/', [AdminListingController::class, 'store'])->name('store');
        Route::get('applications/{application}', [AdminListingController::class, 'showApplication'])->name('application-show');
    });

    // ========== ADMIN APPLICATION ACTIONS ==========
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::post('{application}/accept', [AdminListingController::class, 'acceptApplication'])->name('accept');
        Route::post('{application}/reject', [AdminListingController::class, 'rejectApplication'])->name('reject');
        Route::delete('{application}', [AdminListingController::class, 'destroyApplication'])->name('destroy');
    });

    // ========== ADMIN USER MANAGEMENT ROUTES ==========
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });
});