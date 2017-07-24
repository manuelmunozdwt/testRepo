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


    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{!! asset('css/jquery.ezdz.css') !!}">
    {!! Html::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') !!}
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/custom_style.php') !!}


    <link rel="stylesheet" type="text/css" href="{!! asset('plugins/slick/slick.css') !!}"/>
    <!--Add the new slick-theme.css if you want the default styling
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>-->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 300px;
        }
        .slider {
            display: none;
        }
    </style>

    @section('CSSHeader')
	@show

</head>



	        @yield('content')
	  
		@include('includes.footer')