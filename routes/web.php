<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InspeksiInlineController;
use App\Http\Controllers\InspeksiFinalController;

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

// Select Dropdown
Route::get('/users-sub/{id}', [UsersController::class, 'getSubDepartemen'])->name('users.sub')->middleware('auth.check');
Route::get('/mesin-sub/{id}', [MesinController::class, 'getSubDepartemen'])->name('mesin.sub')->middleware('auth.check');
Route::get('/mesin-dropdown/{id}', [MesinController::class, 'getSubMesin'])->name('mesin.dropdown')->middleware('auth.check');

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

//Inspeksi Inline
Route::get('/inline', [InspeksiInlineController::class, 'InlineList'])->middleware('auth.check');
Route::get('/inline-input', [InspeksiInlineController::class, 'DraftList'])->middleware('auth.check');
Route::get('/inline-input/', [InspeksiInlineController::class, 'InlineInput'])->middleware('auth.check');
Route::post('/inline-input', [InspeksiInlineController::class, 'SaveInlineData'])->name('inline.save')->middleware('auth.check');
Route::get('/inline-edit/{id}', [InspeksiInlineController::class, 'EditInlineData'])->middleware('auth.check');
Route::post('/inline-update/', [InspeksiInlineController::class, 'SaveEditInlineData'])->name('inline.update')->middleware('auth.check');
Route::get('/inline-delete/{id}', [InspeksiInlineController::class, 'DeleteInlineData'])->middleware('auth.check');

Route::get('/inlinelist-delete/{id}', [InspeksiInlineController::class, 'DeleteInlineDataList'])->middleware('auth.check');

// Post Function (Inline)
Route::get('/inline-post/', [InspeksiInlineController::class, 'PostInline'])->middleware('auth.check');

//Inspeksi Final
Route::get('/final', [InspeksiFinalController::class, 'FinalList'])->middleware('auth.check');
Route::get('/final-input', [InspeksiFinalController::class, 'DraftList'])->middleware('auth.check');
Route::get('/final-input/', [InspeksiFinalController::class, 'FinalInput'])->middleware('auth.check');
Route::post('/final-input', [InspeksiFinalController::class, 'SaveFinalData'])->name('final.save')->middleware('auth.check');
Route::get('/final-edit/{id}', [InspeksiFinalController::class, 'EditFinalData'])->middleware('auth.check');
Route::post('/final-update/', [InspeksiFinalController::class, 'SaveEditFinalData'])->name('final.update')->middleware('auth.check');
Route::get('/final-delete/{id}', [InspeksiFinalController::class, 'DeleteFinalData'])->middleware('auth.check');
Route::get('/finallist-delete/{id}', [InspeksiFinalController::class, 'DeleteFinalDataList'])->middleware('auth.check');

// Post Function (Inline)
Route::get('/final-post/', [InspeksiFinalController::class, 'PostFinal'])->middleware('auth.check');
