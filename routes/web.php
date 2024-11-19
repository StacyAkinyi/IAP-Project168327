<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;




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


