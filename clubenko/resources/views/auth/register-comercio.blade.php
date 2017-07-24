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
<body id="login-comercio" class="registro-comercio">
	<div class="row">
        <div class="col-md-12">
            <img class="logo" src="{!! asset('img/logo-enko-azul.png') !!}">
        </div>
        <div class="col-md-12">
            <p class="titulo">Date de alta en el área privada para comercios</p>
            <p class="texto">Accede a toda la información de tu negocio</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal registro-comercio" role="form" method="POST" action="{!! route('registro-comercio') !!}">
                {!! csrf_field() !!}
                

                <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                    <div class="">
                        <label class="label" for="name">Nombre </label>
                        <input  class="login-form" name="name" value="{!! old('name') !!}">

                         @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{!! $errors->first('name') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{!! $errors->has('apellidos') ? ' has-error' : '' !!}">
                    <div class="">
                        <label class="label" for="apellidos">Apellidos </label>
                        <input  class="login-form" name="apellidos" value="{!! old('apellidos') !!}">

                         @if ($errors->has('apellidos'))
                            <span class="help-block">
                                <strong>{!! $errors->first('apellidos') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{!! $errors->has('nombre_comercio') ? ' has-error' : '' !!}">
                    <div class="">
                        <label class="label" for="nombre_comercio">Nombre del comercio </label>
                        <input  class="login-form" name="nombre_comercio" value="{!! old('nombre_comercio') !!}">

                         @if ($errors->has('nombre_comercio'))
                            <span class="help-block">
                                <strong>{!! $errors->first('nombre_comercio') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{!! $errors->has('dni') ? ' has-error' : '' !!}">
                    <div class="">
                        <label class="label" for="dni">DNI</label>
                        <input type="dni" class="login-form" name="dni" value="{!! old('dni') !!}">

                        @if ($errors->has('dni'))
                            <span class="help-block">
                                <strong>{!! $errors->first('dni') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
                    <div class="">
                    	<label class="label" for="email">E-mail</label>
                        <input type="email" class="login-form" name="email" value="{!! old('email') !!}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{!! $errors->first('email') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">

                    <span class="">
                    	<label class="label" for="password">Contraseña</label>
                        <input type="password" class="login-form" name="password">
                    </span>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{!! $errors->first('password') !!}</strong>
                            </span>
                        @endif
                </div>

                <div class="form-group{!! $errors->has('password_confirmation') ? ' has-error' : '' !!}">

                    <div class="">
                    	<label class="label" for="password_confirmation">Repetir Contraseña</label>
                        <input type="password" class="login-form" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{!! $errors->first('password_confirmation') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="enlaces">

                        <a class=" label" href="{!! route('login') !!}">¿Ya tienes una cuenta?</a>
                    </div>
                </div>
        </div>
    </div>
    <button type="submit" class="blue-button">ENTRAR</button>
    </form>

</body>
<script type="text/javascript" src="{!! asset('js/bootstrap-notify.min.js') !!}"></script>
<!-- NOTIFY -->
@if($errors->any())
<script>
  $.notify({
  // options
  message: "{!! string_errors($errors) !!}"
},{
  // settings
  delay: null,
});
@endif
</script>
</html>