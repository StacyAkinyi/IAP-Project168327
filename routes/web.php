<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\TwoFactorController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

Route::get('/signup', [AuthManager::class, 'signup'])->name('signup');
Route::post('/signup', [AuthManager::class, 'signupPost'])->name('signup.post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::get('/two_factor', [AuthManager::class, 'two_factor'])->name('two_factor');
Route::post('/two_factor', [AuthManager::class, 'two_factorPost'])->name('two_factor.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/two_factor', [TwoFactorController::class, 'two_factor'])->name('two_factor');
    Route::post('/two_factor', [TwoFactorController::class, 'two_factorPost'])->name('two_factor.post');
    Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
});