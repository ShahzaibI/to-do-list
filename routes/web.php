<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/todolist/{id}', [TodoController::class, 'completed'])->name('todolist.completed');
Route::group(['prefix'=>'user'],function(){
    Route::get('/login', [UserController::class, 'loginPage'])->name('loginUser');
    Route::get('/register', [UserController::class, 'register'])->name('registerUser');
    Route::post('/user-store', [UserController::class, 'store'])->name('storeUser');
    Route::post('/user-login', [UserController::class, 'login'])->name('loginAuth');
    Route::get('/user-logout', [UserController::class, 'logout'])->name('logoutAuth');
    // Reset Password
    Route::get('/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
    // Forgot password
    Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgotPassword');

    Route::post('/forgot-password-email', [UserController::class, 'sentForgotPasswordEmail'])->name('forgotPasswordEmail');

    Route::get('/reset-password/{token}',[UserController::class, 'resetForm'])->name('password.reset');

    Route::post('/change-password',[UserController::class, 'changePassword'])->name('password.update');
});

Route::group(['middleware'=>'custom_auth'],function(){
    Route::get('/', [TodoController::class, 'index'])->name('home');
    Route::resource('/todolist', TodoController::class);
});