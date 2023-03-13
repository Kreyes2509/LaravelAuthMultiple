<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Mail\MandarCorreo;
use App\Http\Controllers\CodigoController;
use App\Http\Controllers\CifradoController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $user = User::where("email", "=", $request->email)->first();
            $codigo = rand(1000,10000);

            $url=URL::temporarySignedRoute('CodeView', now()->addMinutes(1));

            $CodigoController = app(CodigoController::class);
            $CodigoController->guardarCodigoEmail($user->id,$codigo);

            Mail::to($request->email)->send(new MandarCorreo($user,$codigo,$url));

            return redirect('/login')->with('msg','Te enviamos un codigo de verificacion a tu correo');
        }
        else
        {
           return redirect('/login')->with('msg','credenciales no validas');
        }

    }

    public function Registrar(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = bcrypt($request->input('password'));
        $user->password = $password;
        $user->save();

        if($user->save()){
            return redirect('/login')->with('msg','Bienvenid@!');
        }

        return redirect('/registrar')->with('msg','datos no validos');
    }

    public function cerrarSesion() {
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }

    public function getUserId()
    {
        return Auth::id();
    }
}
