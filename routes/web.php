<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\InspeksiHeaderController;
use App\Http\Controllers\SubDepartmentController;
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
Route::get('/users-edit/{id}', [UsersController::class, 'EditUserData']); // mengarahkan ke window edit data
Route::post('/users-update/', [UsersController::class, 'SaveEditUserData'])->name('users.update'); //simpan perubahan data
Route::get('/users-delete/{id}', [UsersController::class, 'DeleteUserData']); // menghapus data user dari database

// User Change Password
Route::get('/change-password/{id}',[UsersController::class, 'ChangeUserPassword']);
Route::post('/password-update/', [UsersController::class, 'SaveUserPassword'])->name('password.update');

// Master Department
Route::get('/department', [DepartmentController::class, 'DepartmentList']);
Route::get('/department-input/', [DepartmentController::class, 'DepartmentInput']);
Route::post('/department-input/', [DepartmentController::class, 'SaveDepartmentData'])->name('department.save');
Route::get('/department-edit/{id}', [DepartmentController::class, 'EditDepartmentData']); // mengarahkan ke window edit data
Route::post('/department-update/', [DepartmentController::class, 'SaveEditDepartmentData'])->name('department.update'); //simpan perubahan data
Route::get('/department-delete/{id}', [DepartmentController::class, 'DeleteDepartmentData']);

// Master Sub Department
Route::get('/subdepartment', [SubDepartmentController::class, 'SubDepartmentList']);
Route::get('/subdepartment-input/', [SubDepartmentController::class, 'SubDepartmentInput']);
Route::post('/subdepartment-input/', [SubDepartmentController::class, 'SaveSubDepartmentData'])->name('subdepartment.save');
Route::get('/subdepartment-edit/{id}', [SubDepartmentController::class, 'EditSubDepartmentData']); // mengarahkan ke window edit data
Route::post('/subdepartment-update/', [SubDepartmentController::class, 'SaveEditSubDepartmentData'])->name('subdepartment.update'); //simpan perubahan data
Route::get('/subdepartment-delete/{id}', [SubDepartmentController::class, 'DeleteSubDepartmentData']);

// Master Periode
Route::get('/periode', [PeriodeController::class, 'PeriodeList']);
Route::get('/periode-input/', [PeriodeController::class, 'PeriodeInput']);
Route::post('/periode-input/', [PeriodeController::class, 'SavePeriodeData'])->name('periode.save');
Route::get('/periode-edit/{id}', [PeriodeController::class, 'EditPeriodeData']);
Route::post('/periode-update/', [PeriodeController::class, 'SaveEditPeriodeData'])->name('periode.update');
Route::get('/periode-delete/{id}', [PeriodeController::class, 'DeletePeriodeData']);

// Master Inspeksi Header
Route::get('/inspeksiheader', [InspeksiHeaderController::class, 'InspeksiHeaderList']);
Route::get('/inspeksiheader-input/', [InspeksiHeaderController::class, 'InspeksiHeaderInput']);
Route::post('/inspeksiheader-input/', [InspeksiHeaderController::class, 'SaveInspeksiHeaderData'])->name('inspeksiheader.save');
Route::get('/inspeksiheader-edit/{id}', [InspeksiHeaderController::class, 'EditInspeksiHeaderData']);
Route::post('/inspeksiheader-update/', [InspeksiHeaderController::class, 'SaveEditInspeksiHeaderData'])->name('inspeksiheader.update');
Route::get('/inspeksiheader-delete/{id}', [InspeksiHeaderController::class, 'DeleteInspeksiHeaderData']);