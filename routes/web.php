<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModulePermissionController;
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
    Route::get('/operacion_staff_staff', [ModulePermissionController::class, 'modulesPermissions'])->name('operacion_staff_staff');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('getModules', [ModuleController::class, 'getModules']);
Route::post('createModifyModule', [ModuleController::class, 'createModifyModule']);
Route::get('getUsers', [UserController::class, 'getUsers']);
Route::post('createModifyUser', [UserController::class, 'createModifyUser']);
Route::post('updateUsersPermissions', [UserPermissionController::class, 'updateUsersPermissions']);
Route::post('updateModulesPermissions', [ModulePermissionController::class, 'updateModulesPermissions']);
Route::post('deletePermissionUser', [ModulePermissionController::class, 'deletePermissionUser']);