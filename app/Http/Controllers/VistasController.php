<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodigoController;

class VistasController extends Controller
{
    public function loginView()
    {
        return view('Auth.login');
    }
    public function signupView()
    {
        return view('Auth.registrar');
    }
    public function dashboardView()
    {
        return view('Auth.dashboard');
    }

    public function CodeView(Request $request)
    {
        if (!$request->hasValidSignature()) {
            $AuthController = app(AuthController::class);
            $CodigoController = app(CodigoController::class);
            $CodigoController->EliminarCodigos(Auth::user()->id);
            $AuthController->cerrarSesion();
            abort(419);
        }
        return view('mail.vistaConfirmarCorreo');
    }
}
