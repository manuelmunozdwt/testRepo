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
<body id="login-comercio" class="login-comercio">
    <div class="">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <img class="logo" src="{!! asset('img/logo-enko-azul.png') !!}">
            </div>
            <div class="col-md-12">
                <p class="titulo">Accede al área privada para comercios</p>
                <p class="texto">Accede a toda la información de tu negocio</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
     
                <form class="form-horizontal" role="form" method="POST" action="{!! url('/login') !!}">
                    {!! csrf_field() !!}

                    <div class="form-group{!! $errors->has('dni') ? ' has-error' : '' !!}">
                        <div class="">
                            <label class="label" for="dni">Usuario (DNI)</label>
                            <input type="dni" class="login-form" name="dni" value="{!! old('dni') !!}">

                            @if ($errors->has('dni'))
                                <span class="help-block">
                                    <strong>{!! $errors->first('dni') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                        <div class="">
                            <label class="label" for="dni">Contraseña</label>
                            <input type="password" class="login-form" name="password" >

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{!! $errors->first('password') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <!-- .squaredThree -->
                            <div class="squaredThree">
                              <input type="checkbox" value="None" id="squaredThree" name="check" />
                              <label for="squaredThree"></label><span>RECUÉRDAME</span>
                            </div>
                            <!-- end .squaredThree -->

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="enlaces">
                            <a class="recuperar-pass label" href="{!! route('reset-comercio') !!}">¿Olvidaste tu contraseña?</a>
                            <a class=" label" href="{!! route('registro') !!}">¿Todavía no tienes una cuenta?</a>
                        </div>
                    </div>

                <button type="submit" class="blue-button">ENTRAR</button>
            </div>
        </div>

        </form>
    </div>

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
</body>
</html>

