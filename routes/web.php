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
Route::get('/dashboard', [DashboardController::class, 'Index'])->middleware('auth.check');

// Master Users
Route::get('/users', [UsersController::class, 'UsersList'])->middleware('auth.check'); // menampilkan semua data dalam list datatable
Route::get('/users-input/', [UsersController::class, 'UsersInput'])->middleware('auth.check'); // mengarahkan ke window input user
Route::post('/users-input/', [UsersController::class, 'SaveUserData'])->name('users.save')->middleware('auth.check'); // simpan data user dalam database
Route::get('/users-edit/{id}', [UsersController::class, 'EditUserData'])->middleware('auth.check'); // mengarahkan ke window edit data
Route::post('/users-update/', [UsersController::class, 'SaveEditUserData'])->name('users.update')->middleware('auth.check'); //simpan perubahan data
Route::get('/users-delete/{id}', [UsersController::class, 'DeleteUserData']); // menghapus data user dari database
Route::get('/getSubDept/{id}', 'UsersController@getSubDept')->middleware('auth.check');

// Sub Departemen Select Dropdown
Route::get('/users-sub/{id}', [UsersController::class, 'getSubDepartemen'])->name('users.sub')->middleware('auth.check');
Route::get('/mesin-sub/{id}', [MesinController::class, 'getSubDepartemen'])->name('mesin.sub')->middleware('auth.check');

// User Change Password
Route::get('/change-password/{id}',[UsersController::class, 'ChangeUserPassword'])->middleware('auth.check');
Route::post('/password-update/', [UsersController::class, 'SaveUserPassword'])->name('password.update')->middleware('auth.check');

// Master Department
Route::get('/department', [DepartmentController::class, 'DepartmentList'])->middleware('auth.check');
Route::get('/department-input/', [DepartmentController::class, 'DepartmentInput'])->middleware('auth.check');
Route::post('/department-input/', [DepartmentController::class, 'SaveDepartmentData'])->name('department.save')->middleware('auth.check');
Route::get('/department-edit/{id}', [DepartmentController::class, 'EditDepartmentData'])->middleware('auth.check'); // mengarahkan ke window edit data
Route::post('/department-update/', [DepartmentController::class, 'SaveEditDepartmentData'])->name('department.update')->middleware('auth.check'); //simpan perubahan data
Route::get('/department-delete/{id}', [DepartmentController::class, 'DeleteDepartmentData'])->middleware('auth.check');

// Master Sub Department
Route::get('/subdepartment', [SubDepartmentController::class, 'SubDepartmentList'])->middleware('auth.check');
Route::get('/subdepartment-input/', [SubDepartmentController::class, 'SubDepartmentInput'])->middleware('auth.check');
Route::post('/subdepartment-input/', [SubDepartmentController::class, 'SaveSubDepartmentData'])->name('subdepartment.save')->middleware('auth.check');
Route::get('/subdepartment-edit/{id}', [SubDepartmentController::class, 'EditSubDepartmentData'])->middleware('auth.check'); // mengarahkan ke window edit data
Route::post('/subdepartment-update/', [SubDepartmentController::class, 'SaveEditSubDepartmentData'])->name('subdepartment.update')->middleware('auth.check'); //simpan perubahan data
Route::get('/subdepartment-delete/{id}', [SubDepartmentController::class, 'DeleteSubDepartmentData'])->middleware('auth.check');

// Master Periode
Route::get('/periode', [PeriodeController::class, 'PeriodeList'])->middleware('auth.check');
Route::get('/periode-input/', [PeriodeController::class, 'PeriodeInput'])->middleware('auth.check');
Route::post('/periode-input/', [PeriodeController::class, 'SavePeriodeData'])->name('periode.save')->middleware('auth.check');
Route::get('/periode-edit/{id}', [PeriodeController::class, 'EditPeriodeData'])->middleware('auth.check');
Route::post('/periode-update/', [PeriodeController::class, 'SaveEditPeriodeData'])->name('periode.update')->middleware('auth.check');
Route::get('/periode-delete/{id}', [PeriodeController::class, 'DeletePeriodeData'])->middleware('auth.check');

// Master Mesin
Route::get('/mesin', [MesinController::class, 'MesinList'])->middleware('auth.check');
Route::get('/mesin-input/', [MesinController::class, 'MesinInput'])->middleware('auth.check');
Route::post('/mesin-input', [MesinController::class, 'SaveMesinData'])->name('mesin.save')->middleware('auth.check');
Route::get('/mesin-edit/{id}', [MesinController::class, 'EditMesinData'])->middleware('auth.check');
Route::post('/mesin-update/', [MesinController::class, 'SaveEditMesinData'])->name('mesin.update')->middleware('auth.check');
Route::get('/mesin-delete/{id}', [MesinController::class, 'DeleteMesinData'])->middleware('auth.check');

// Master Defect
Route::get('/defect', [DefectController::class, 'DefectList'])->middleware('auth.check');
Route::get('/defect-input/', [DefectController::class, 'DefectInput'])->middleware('auth.check');
Route::post('/defect-input', [DefectController::class, 'SaveDefectData'])->name('defect.save')->middleware('auth.check');
Route::get('/defect-edit/{id}', [DefectController::class, 'EditDefectData'])->middleware('auth.check');
Route::post('/defect-update/', [DefectController::class, 'SaveEditDefectData'])->name('defect.update')->middleware('auth.check');
Route::get('/defect-delete/{id}', [DefectController::class, 'DeleteDefectData'])->middleware('auth.check');

// // Dropdown dependent Sub Departemen
// Route::get('/dropdown-sub-departemen/{id}', function ($id) {
//     $dropdown_sub_departemen = App\Models\SubDepartmentModel::where('id_departemen',$id)->get();
//     return response()->json($dropdown_sub_departemen);
// });

// // Master Inspeksi Header
// Route::get('/inspeksiheader', [InspeksiHeaderController::class, 'InspeksiHeaderList'])->middleware('auth.check');
// Route::get('/inspeksiheader-input/', [InspeksiHeaderController::class, 'InspeksiHeaderInput'])->middleware('auth.check');
// Route::post('/inspeksiheader-input', [InspeksiHeaderController::class, 'SaveInspeksiHeaderData'])->name('inspeksiheader.save')->middleware('auth.check');
// Route::get('/inspeksiheader-edit/{id}', [InspeksiHeaderController::class, 'EditInspeksiHeaderData'])->middleware('auth.check');
// Route::post('/inspeksiheader-update/', [InspeksiHeaderController::class, 'SaveEditInspeksiHeaderData'])->name('inspeksiheader.update')->middleware('auth.check');
// Route::get('/inspeksiheader-delete/{id}', [InspeksiHeaderController::class, 'DeleteInspeksiHeaderData'])->middleware('auth.check');
