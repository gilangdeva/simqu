<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
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
Route::post('/auth-login', [AuthController::class, 'AuthLogin'])->name('auth.login'); 
Route::get('/auth-logout/{id}', [AuthController::class, 'AuthLogout']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'Index']);

// Master Users
Route::get('/users', [UsersController::class, 'UsersList']); // menampilkan semua data dalam list datatable
Route::get('/users-input/', [UsersController::class, 'UsersInput']); // mengarahkan ke window input user
Route::post('/users-input/', [UsersController::class, 'SaveUserData'])->name('users.save'); // simpan data user dalam database
Route::get('/users-delete/{id}', [UsersController::class, 'DeleteUserData']); // menghapus data user dari database
