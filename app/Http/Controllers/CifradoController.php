<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Encryption\Encrypter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class CifradoController extends Controller
{

    public function Encriptar($codigo)
    {
        $cadenaEncriptada = Crypt::encryptString($codigo);
        return $cadenaEncriptada;
    }

    public function Desencriptar($codigo)
    {
        $cadenaDesencriptada = Crypt::decryptString($codigo);
        return $cadenaDesencriptada;
    }

}
