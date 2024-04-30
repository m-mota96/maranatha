<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/configuracion_menu', [ModuleController::class, 'modules'])->name('configuracion_menu');
    Route::get('/configuracion_usuarios', [UserController::class, 'users'])->name('configuracion_usuarios');
    Route::get('/configuracion_permisos_usuarios', [UserPermissionController::class, 'usersPermissions'])->name('configuracion_permisos_usuarios');
    Route::get('/configuracion_permisos_modulos', [ModulePermissionController::class, 'modulesPermissions'])->name('configuracion_permisos_modulos');
    Route::get('/organizacion_staff_staff', [StaffController::class, 'staff'])->name('organizacion_staff_staff');
    Route::get('/organizacion_staff_puestos', [PositionController::class, 'positions'])->name('organizacion_staff_puestos');
    Route::get('/operacion_servicios', [ServiceController::class, 'services'])->name('operacion_servicios');
    Route::get('/operacion_productos', [ProductController::class, 'products'])->name('operacion_productos');
    Route::get('/operacion_paquetes', [PackageController::class, 'packages'])->name('operacion_paquetes');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('getModules', [ModuleController::class, 'getModules']);
Route::get('getUsers', [UserController::class, 'getUsers']);
Route::get('getPositions', [PositionController::class, 'getPositions']);
Route::get('getStaff', [StaffController::class, 'getStaff']);
Route::get('getServices', [ServiceController::class, 'getServices']);
Route::get('getCustomers', [CustomerController::class, 'getCustomers']);

Route::post('createModifyModule', [ModuleController::class, 'createModifyModule']);
Route::post('createModifyUser', [UserController::class, 'createModifyUser']);
Route::post('updateUsersPermissions', [UserPermissionController::class, 'updateUsersPermissions']);
Route::post('updateModulesPermissions', [ModulePermissionController::class, 'updateModulesPermissions']);
Route::post('deletePermissionUser', [ModulePermissionController::class, 'deletePermissionUser']);
Route::post('createModifyPosition', [PositionController::class, 'createModifyPosition']);
Route::post('createModifyStaff', [StaffController::class, 'createModifyStaff']);
Route::post('updateSchedulesStaff', [StaffController::class, 'updateSchedulesStaff']);
Route::post('updateImgProfileStaff', [StaffController::class, 'updateImgProfileStaff']);
Route::post('createModifyService', [ServiceController::class, 'createModifyService']);
Route::post('createModifyCustomers', [CustomerController::class, 'createModifyCustomers']);
Route::post('searchStaff', [HomeController::class, 'searchStaff']);