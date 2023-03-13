<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VistasController;
use App\Http\Controllers\CodigoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Auth.login');
});

Route::get('login', [VistasController::class, 'loginView'])->name('login');
Route::post('sesion', [AuthController::class, 'login'])->name('sesion');
Route::get('registrar', [VistasController::class, 'signupView'])->name('registrar');
Route::post('signUp', [AuthController::class, 'Registrar'])->name('signUp');

Route::middleware('codigo')->group(function () {
    Route::get('dashboard', [VistasController::class, 'dashboardView'])->name('dashboardView');
    Route::get('signout', [AuthController::class, 'cerrarSesion'])->name('signout');
});

Route::middleware('auth')->group(function () {
    Route::get('verificarCode', [VistasController::class, 'CodeView'])->name('CodeView');
    Route::post('verificar', [CodigoController::class, 'validarCodigo'])->name('validarCodigo');
});
