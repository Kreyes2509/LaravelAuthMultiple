@extends('correolayout')

@section('conteiner')

<h1>BIENVENID@:{{$name}}</h1>
<p>Ingresa el siguiente codigo en tu telefono:{{$codigo}}</p><br>
<p>posteriormente te generara un codigo que ingresaras en el siguiente link</p><br>
<p>el cual vencera dentro de 2 minutos</p>
<a href="{{$url}}">Verificar codigo</a>
{{-- <a href="{{$url}}">verificar codigo</a> --}}

@endsection


