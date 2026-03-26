<?php

// importing the controller

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//

// register router;

Route::get('/register', [UserController::class, 'showregisterUser'])
    ->name('showregisterUser')
    ->middleware('guest');
Route::post('/register', [UserController::class, 'registerUser'])->name('registerUser');

// login

Route::get('/login', [UserController::class, 'login'])->name('login')
    ->middleware('guest');
Route::post('/login', [UserController::class, 'loginUser'])->name('loginUser');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');






// for admin only

Route::get('/admin',[AdminController::class,'admincontrollerget'])->name('admincontrollerget');
Route::post('/admin',[AdminController::class,'admincontrollerpost'])->name('admincontrollerpost');
