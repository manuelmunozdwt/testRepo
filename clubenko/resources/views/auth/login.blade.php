@extends('layouts.app')

@section('content')
<div id="content" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <p class="texto">Accede a tu área de usuario y descubre las mejores promociones</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
 
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('dni') ? ' has-error' : '' }}">
                    <div class="col-md-6  col-lg-6 col-lg-offset-3 col-lg-6">
                        <input type="dni" class="login-form" name="dni" value="{{ old('dni') }}" placeholder="DNI">

                        @if ($errors->has('dni'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dni') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-6  col-lg-6 col-lg-offset-3">
                        <input type="password" class="login-form" name="password" placeholder="Contraseña">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6  col-lg-6 col-lg-offset-3 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Recordar 
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6  col-lg-6 col-lg-offset-3 col-md-offset-4">
                        <a class="recuperar-pass" href="{{ url('/password/reset') }}">Olvidé mi contraseña</a>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6  col-lg-6 col-lg-offset-3 col-md-offset-4">
                        <button type="submit" class="blue-button">Entrar</button>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
