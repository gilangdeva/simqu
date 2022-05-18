<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MesinController;
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

// Sub Departemen Select Dropdown
Route::get('/subdepartment-select/{id}', [SubDepartmentController::class, 'SelectSubDepartmentData'])->name('sub_departemen.select');

// Master Periode
Route::get('/periode', [PeriodeController::class, 'PeriodeList']);
Route::get('/periode-input/', [PeriodeController::class, 'PeriodeInput']);
Route::post('/periode-input/', [PeriodeController::class, 'SavePeriodeData'])->name('periode.save');
Route::get('/periode-edit/{id}', [PeriodeController::class, 'EditPeriodeData']);
Route::post('/periode-update/', [PeriodeController::class, 'SaveEditPeriodeData'])->name('periode.update');
Route::get('/periode-delete/{id}', [PeriodeController::class, 'DeletePeriodeData']);

// Master Mesin
Route::get('/mesin', [MesinController::class, 'MesinList']);
Route::get('/mesin-input/', [MesinController::class, 'MesinInput']);
Route::post('/mesin-input', [MesinController::class, 'SaveMesinData'])->name('mesin.save');
Route::get('/mesin-edit/{id}', [MesinController::class, 'EditMesinData']);
Route::post('/mesin-update/', [MesinController::class, 'SaveEditMesinData'])->name('mesin.update');
Route::get('/mesin-delete/{id}', [MesinController::class, 'DeleteMesinData']);

// Master Defect
Route::get('/defect', [DefectController::class, 'DefectList']);
Route::get('/defect-input/', [DefectController::class, 'DefectInput']);
Route::post('/defect-input', [DefectController::class, 'SaveDefectData'])->name('defect.save');
Route::get('/defect-edit/{id}', [DefectController::class, 'EditDefectData']);
Route::post('/defect-update/', [DefectController::class, 'SaveEditDefectData'])->name('defect.update');
Route::get('/defect-delete/{id}', [DefectController::class, 'DeleteDefectData']);

// Dropdown dependent Sub Departemen
Route::get('/dropdown-sub-departemen/{id}', function ($id) {
    $dropdown_sub_departemen = App\Models\SubDepartmentModel::where('id_departemen',$id)->get();
    return response()->json($dropdown_sub_departemen);
});

// Master Inspeksi Header
Route::get('/inspeksiheader', [InspeksiHeaderController::class, 'InspeksiHeaderList']);
Route::get('/inspeksiheader-input/', [InspeksiHeaderController::class, 'InspeksiHeaderInput']);
Route::post('/inspeksiheader-input', [InspeksiHeaderController::class, 'SaveInspeksiHeaderData'])->name('inspeksiheader.save');
Route::get('/inspeksiheader-edit/{id}', [InspeksiHeaderController::class, 'EditInspeksiHeaderData']);
Route::post('/inspeksiheader-update/', [InspeksiHeaderController::class, 'SaveEditInspeksiHeaderData'])->name('inspeksiheader.update');
Route::get('/inspeksiheader-delete/{id}', [InspeksiHeaderController::class, 'DeleteInspeksiHeaderData']);
