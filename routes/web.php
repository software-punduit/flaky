<?php

use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FundWalletController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawWalletController;
use App\Http\Controllers\RestaurantStaffController;
use App\Http\Controllers\RestaurantTableController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('profiles', ProfileController::class);

    Route::resource('users', UserController::class);

    Route::resource('restaurants', RestaurantController::class);

    Route::resource('restaurant-staff', RestaurantStaffController::class);

    Route::resource('restaurant-tables', RestaurantTableController::class);

    Route::resource('menus', MenuController::class);

    Route::resource('orders', OrderController::class);

    Route::resource('transactions', TransactionController::class);

    Route::get('fund-wallet', [FundWalletController::class, 'create'])->name('fund-wallet.create');
    Route::post('fund-wallet', [FundWalletController::class, 'store'])->name('fund-wallet.store');

    Route::get('withdraw-wallet', [WithdrawWalletController::class, 'create'])->name('withdraw-wallet.create');
    Route::post('withdraw-wallet', [WithdrawWalletController::class, 'store'])->name('withdraw-wallet.store');
});
