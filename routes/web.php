<?php

use App\Http\Controllers\ModulesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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
    Route::get('/configuracion_menu', [ModulesController::class, 'modules'])->name('configuracion_menu');
    Route::get('/configuracion_usuarios', [UserController::class, 'users'])->name('configuracion_usuarios');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('getModules', [ModulesController::class, 'getModules']);
Route::post('createModifyModule', [ModulesController::class, 'createModifyModule']);
Route::get('getUsers', [UserController::class, 'getUsers']);