<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PickupRequestController;
use App\Http\Controllers\PackagePickupController;
use Illuminate\Support\Facades\Auth;

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

// Public Routes
Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Auth::routes();

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/estimate-cost', [PickupRequestController::class, 'calculateEstimate']);
    Route::get('/pickup-requests/{id}/quote', [PickupRequestController::class, 'generateQuote'])->name('pickup-requests.quote');
    Route::get('/estimate-cost', [PickupRequestController::class, 'calculateEstimate']);
    Route::get('/pickup-requests/create', [PickupRequestController::class, 'create'])->name('pickup-requests.create');
    Route::put('/pickup-requests', [PickupRequestController::class, 'store'])->name('pickup-requests.store');
    Route::get('/pickup-requests/schedule', [PickupRequestController::class, 'schedule'])->name('pickup-requests.schedule');
    Route::get('/driver/dashboard', [PackagePickupController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/driver/pickup/create', [PackagePickupController::class, 'createPickupRequest'])->name('driver.pickup.create');
    Route::put('/driver/pickup', [PackagePickupController::class, 'storePickupRequest'])->name('driver.pickup.store');
    Route::put('/driver/package/{package}', [PackagePickupController::class, 'updatePackageStatus'])->name('driver.package.update');
    Route::get('/packages/{package}/assign', [PackagePickupController::class, 'assignToMe'])->name('packages.assign');


    // Manager-specific Routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager/dashboard', [HomeController::class, 'index'])->name('manager.dashboard');
        Route::get('/manager/users/create', [UserController::class, 'create'])->name('manager.users.create');
        Route::post('/manager/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('manager/users', [UserController::class, 'index'])->name('users.index'); // View all users
        Route::get('manager/users/{user}', [UserController::class, 'show'])->name('users.show'); // View a single user
        Route::get('manager/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Edit user form
        Route::put('manager/users/{user}', [UserController::class, 'update'])->name('users.update'); // Update user
    });

    // Customer-specific Routes
    Route::middleware(['role:customer'])->group(function () {
       
    });

    // Driver-specific Routes
    Route::middleware(['role:driver'])->group(function () {
   
    Route::post('/packages/{package}/update-status', [PackagePickupController::class, 'updateStatus'])->name('packages.updateStatus');
    Route::get('/packages/{package}/edit', [PackagePickupController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}', [PackagePickupController::class, 'update'])->name('packages.update');
    Route::get('/packages/{package}/invoice', [PackagePickupController::class, 'invoice'])->name('packages.invoice');
       
    });
});
