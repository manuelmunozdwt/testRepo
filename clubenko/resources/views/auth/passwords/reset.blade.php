@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p class="texto">Gracias por registrarte en Enkoteams. <br> Si se te ha olvidado tu contraseña, podemos ayudarte a acceder a tu área de usuario. Introduce tu e-mail y escribe una nueva contraseña.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-6">
                    <input type="email" class="login-form" name="email" value="{{ old('email') }}" placeholder="E-mail">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-6">
                    <input type="password" class="login-form" name="password" placeholder="Nueva contraseña">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="col-md-6">
                    <input type="password" class="login-form" name="password_confirmation" placeholder="Repetir contraseña">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="blue-button">
                        Restablecer contraseña
                    </button>
                </div>
            </div>
        </form>


    </div>
</div>
@endsection
