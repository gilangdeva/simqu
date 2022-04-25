<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Auth 
Route::get('/login', [AuthController::class, 'LoginView']);
Route::post('/auth-login', [AuthController::class, 'AuthLogin'])->name('auth.login'); // auth.login digunakan untuk validasi, ketika belum login maka akan diarahkan ke halaman login
Route::get('/auth-logout/{id}', [AuthController::class, 'AuthLogout']);

// Users
Route::get('/users', 'App\Http\Controllers\UsersController@users');
//add user
Route::get('/users/adduser', 'App\Http\Controllers\UsersController@adduser');
Route::post('/users/store', 'App\Http\Controllers\UsersController@store');
//edit user
Route::get('/users/edit_user/{id}','App\Http\Controllers\UsersController@edit_user');
Route::post('/users/update','App\Http\Controllers\UsersController@update');

// Dashboard