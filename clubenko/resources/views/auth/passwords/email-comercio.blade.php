<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1.0">
    <title>{!! Config::get('constantes.cliente') !!}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{!! asset('fonts/Montserrat-Semibold.otf') !!}"/>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="{!! asset('css/jquery.ezdz.css') !!}">
    {!! Html::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') !!}
    {!! Html::style('css/style.css') !!}


    <link rel="stylesheet" type="text/css" href="{!! asset('plugins/slick/slick.css') !!}"/>
    <!--Add the new slick-theme.css if you want the default styling
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>-->


    @section('CSSHeader')
    @show

</head>
<body id="login-comercio" class="reset-comercio">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <img class="logo" src="{!! asset('img/logo-enko-azul.png') !!}">
            </div>
            <div class="col-md-12">
                <p class="titulo">¿Olvidaste tu contraseña?</p>
                <p class="texto">Te ayudamos a recuperarla</p>
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
                <div class="">
                    <input type="email" class="login-form" name="email" value="{{ old('email') }}" placeholder="E-mail">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


    </div>
    <button type="submit" class="blue-button">
        Enviar e-mail
    </button>

</form>
</body>
