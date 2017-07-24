@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="texto">Introduce tu e-mail y te mandaremos instrucciones para restablecer tu contraseña</p>
            </div>
        </div>
                
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}

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

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="blue-button">
                        Enviar e-mail
                    </button>
                </div>
            </div>
        </form>


</div>
@endsection
