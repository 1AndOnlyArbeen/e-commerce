<?php

// importing the controller

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('index');

// catageory of welcome home
Route::get('/category/{category}', [HomeController::class, 'index'])
    ->name('category');

//

// register router;

Route::get('/register', [UserController::class, 'showregisterUser'])
    ->name('showregisterUser')
    ->middleware('guest');
Route::post('/register', [UserController::class, 'registerUser'])->name('registerUser');

// login

Route::get('/login', [UserController::class, 'login'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [UserController::class, 'loginUser'])->name('loginUser');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// for admin only

Route::resource('/admin', AdminController::class);

Route::resource('/categories', CategoryController::class);

// for the product edit and update

Route::put('/admin/products/{id}', [AdminController::class, 'update']);
Route::delete('/admin/products/{id}', [AdminController::class, 'destroy']);

// for cartitem route
Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'get']);
Route::post('/cart/remove', [CartController::class, 'remove']);
Route::post('/cart/merge', [CartController::class, 'merge']);
