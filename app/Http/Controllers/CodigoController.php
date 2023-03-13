<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\CifradoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CodigoController extends Controller
{

    private $CifradoController;

    public function __construct()
    {
        $this->CifradoController = app(CifradoController::class);
    }


    public function guardarCodigoEmail($id,$codigo){
        $user = User::find($id);
        $user->codigo_correo = $this->CifradoController->Encriptar($codigo);
        $user->save();
    }

    public function guardarCodigoApp($id,$codigo){
        $user = User::find($id);
        $user->codigo_telefono = $this->CifradoController->Encriptar($codigo);
        $user->save();
    }

    public function EliminarCodigos($id){
        $user = User::find($id);
        $user->codigo_correo = null;
        $user->codigo_telefono = null;
        $user->save();
    }

    public function codigoApp(Request $request){


        $usuarios = DB::table('users')->get();

        if(!$usuarios)
        {
            return response()->json([
                "Status"=>404,
                "msg"=>"El codigo es incorrecto",
            ],404);
        }
        else
        {
            foreach($usuarios as $email){
                if($this->CifradoController->Desencriptar($email->codigo_correo) == $request->codigo)
                {
                    $codigo = rand(1000,10000);
                    self::guardarCodigoApp($email->id,$codigo);
                    return response()->json([
                        "Status"=>200,
                        "msg"=>"Nuevo codigo",
                        "codigo"=> $codigo
                    ],200);
                }
            }
        }
    }
    public function validarCodigo(Request $request){
        $request->validate([
            'codigo'=>'required',
        ]);
        $user = User::find(Auth::user()->id);
        if(!$user)
        {

        }
        else
        {
            $user->codigo_telefono = $this->CifradoController->Desencriptar($user->codigo_telefono);
            $user->save();

            $validarCodigo = User::where("codigo_telefono", "=", $request->codigo)->first();
            if(!$validarCodigo)
            {
                return redirect('/verificarCode')->with('msg','codigo no valido');
            }
            else
            {
                $user->codigo_correo = $this->CifradoController->Encriptar($user->codigo_correo);
                $user->codigo_telefono = $this->CifradoController->Encriptar($user->codigo_telefono);
                $user->status = true;
                $user->save();
                if($user->save())
                {
                    self::EliminarCodigos(Auth::user()->id);
                    return redirect('/dashboard')->with('msg','Bienvenid@');
                }
            }
        }
    }
}
