<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="canonical" href="https://www.ClubEnko.com">
    <title>{!! Config::get('constantes.cliente') !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="{!! asset('css/jquery.ezdz.css') !!}">
    {!! Html::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') !!}
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/custom_style.php') !!}
    <link rel="stylesheet" type="font/opentype" href="{!! public_path('fonts/Montserrat-Semibold.otf') !!}"/>

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
	<style>
		div.thumbnail {
			padding: 0px;
			border: 0px !important;
	    }
	</style>

    @section('CSSHeader')
	@show

</head>
<body id="app-layout">
    <div id="wrapper">
        <div id="header">
            <nav class="navbar navbar-static-top">
                <div class="container menu">
                    <a class="navbar-center navbar-brand visible-xs" href="{!! route('home') !!}">
                        <img src="{!! asset('/img/'.Config::get('constantes.logo')) !!}">
                    </a>
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
    

                    @if (Auth::check())
                    
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
    
                        <div class="col-md-5">
                            <ul class="nav navbar-nav navbar-left">
                                @if (has_permiso('Ver lista promociones'))
                                    <li><a href="{!! route('listar-promociones', Auth::user()->slug) !!}">Mis promociones</a></li>
                                @endif

                                @if (has_permiso('Ver lista cupones'))
                                    <li><a href="{!! route('listar-cupones', Auth::user()->slug) !!}">Mis cupones</a></li>
                                @endif

                                @if(es_usuario(Auth::user()))
                                    <li><a href="{{ route('mis-cupones', Auth::user()->slug) }}">Ver mis cupones</a></li>
                                @endif

                                @if(es_usuario(Auth::user()))
                                    <li><a href="{!! route('descuentos') !!}">Descuentos</a></li>  
                                @endif

                                @if (has_permiso('Ver mis tiendas'))
                                    <li><a href="{!! route('listar-tiendas', Auth::user()->slug) !!}">Mis tiendas</a></li>
                                @endif

                                
                                
                            </ul>
                        </div>
                        <!-- Branding Image -->
                        <div class="col-md-2 hidden-xs">
                            <a class="navbar-center navbar-brand" href="{!! url('/') !!}">
                                <img src="{!! asset('/img/'.Config::get('constantes.logo')) !!}">
                            </a>
                        </div>            
                        <div class="col-md-5">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Gestión <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">

                                        <li><a href="{!! route('mis_datos') !!}">Mi cuenta</a></li>

                                        @if(has_permiso('Ver lista usuarios'))
                                            <li><a href="{!! url('lista-usuarios') !!}">Gestionar Usuarios</a></li>
                                        @endif

                                        @if(has_permiso('Gestionar tiendas'))
                                            <li><a href="{!! route('ver-tiendas') !!}">Gestionar Tiendas</a></li>
                                        @endif
                                        
                                        @if(has_permiso('Crear categoría'))
                                            <li><a href="{!! route('categorias.create') !!}">Categorías</a></li>
                                        @endif

                                        @if(has_permiso('Editar home'))
                                            <li><a href="{!! route('bloques.index') !!}">Editar Home</a></li>
                                        @endif

                                        @if(has_permiso('Ver lista roles'))
                                            <li><a href="{!! route('roles.index') !!}">Permisos</a></li>
                                        @endif

                                        @if(es_administrador(Auth::user()))
                                            <li><a href="{!! route('banner_cabecera') !!}">Editar Banner Cabecera</a></li>
                                        @endif

                                        @if(es_administrador(Auth::user()))
                                            <li><a href="{!! route('banner_home') !!}">Editar Banner Home</a></li>
                                        @endif

                                        @if(es_administrador(Auth::user()))
                                            <li><a href="{!! route('custom_categorias') !!}">Custom Categorías</a></li>
                                        @endif

                                        @if(es_administrador(Auth::user()))
                                            <li><a href="{!! route('banners_menu') !!}">Banners Menú</a></li>
                                        @endif

                                    </ul>
                                </li>
                                    @if(has_permiso('Validar tiendas') || has_permiso('Validar cupones'))
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                Validaciones <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">

                                                @if(has_permiso('Validar usuarios'))
                                                    <li><a href="{!! route('usuarios.index') !!}">Usuarios</a></li>
                                                @endif

                                                @if(has_permiso('Validar categorías'))
                                                    <li><a href="{!! route('categorias.index') !!}">Categorías</a></li>
                                                @endif

                                                @if(has_permiso('Validar tiendas'))
                                                    <li><a href="{!! route('tiendas.index') !!}">Tiendas</a></li>
                                                @endif

                                                @if(has_permiso('Validar comentarios'))
                                                    <li><a href="{!! route('comentarios.index') !!}">Comentarios</a></li>
                                                @endif

                                                @if(has_permiso('Validar cupones'))
                                                    <li><a href="{!! route('cupones.index') !!}">Cupones</a></li>
                                                @endif

                                                @if(has_permiso('Validar subcategorías'))
                                                    <li><a href="{!! route('subcategorias.index') !!}">Subcategorías</a></li>
                                                @endif

                                                @if(has_permiso('Validar promociones'))
                                                    <li><a href="{!! route('promociones.index') !!}">Promociones</a></li>
                                                @endif


                                            </ul>
                                        </li>
                                    @endif

                                <li><a href="{!! url('/logout') !!}"><i class="fa fa-btn fa-sign-out"></i>Desconectar</a></li>
                                
                            </ul>
                        </div>

                    </div>

                    @else

                        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="{!! route('descuentos') !!}">Descuentos</a></li>  
                                <li><a href="{!! route('login') !!}">Entrar</a></li>
                                <li><a href="{!! route('registro') !!}">Registrarse</a></li>
                            </ul>
                        </div>

                    @endif

                </div><!-- /.container-fluid -->
            </nav>  
        </div>
    	<div id="content">
        @yield('content')
    	</div>


@include('includes.footer')


