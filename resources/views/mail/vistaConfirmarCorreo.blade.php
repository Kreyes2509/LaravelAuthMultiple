@extends('diseño')

<div class="login"style="text-align: center;width: 50%">
    <form method="POST" action="{{url("verificar")}}"  style="width: 50%">
        <h1>Verificar codigo</h1>
        @csrf
        <div class="mb-3">
            <input type="text" name="codigo" maxlength="4" placeholder="codigo" required="required" />
            @error('codigo')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-large">Verificar</button><br>
    </form>
</div>
