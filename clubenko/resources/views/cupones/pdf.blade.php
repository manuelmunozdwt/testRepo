<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1.0">

    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/pdf.css') !!}

</head>
<body id="app-layout" class="pdf">
	<div id="header">
	    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <div class="logo-container">
                    <a class="navbar-brand" href="{!! url('/') !!}">
                        <img src="{!! asset('img/logo-enkoteam.png') !!}">
                    </a>
                </div>
            </div>
        </div>
	</div>
    <div  class="pdf-body">
        <div class="descripcion-cupon">
            <div class="imagen-cupon">
                <div class="promo">
                    <div class="brand" style="position:relative">
                        @if($cupon->logo == 'logo')
                            <div class="logo-tienda" style="position:absolute;top:0;right:0;">
                                @if($imagen == '')
                                    <img src="{!! asset('/img/600x600.png') !!}" width="120px">
                                @else
                                    <img src="{!! asset($imagen) !!}" width="120px">
                                @endif

                            </div>
                        @elseif($cupon->logo == 'blanco')
                            <div class="logo-blanco" style="opacity:0.6;position:absolute;top:0;right:0;"><a href="" style="opacity:1;">{!! $cupon->tienda->first()->usuario()->first()->name !!}</a></div>
                        @elseif($cupon->logo == 'negro')
                            <div class="logo-negro" style="opacity:0.6;position:absolute;top:0;right:0;"><a href="">{!! $cupon->tienda->first()->usuario()->first()->name !!}</a></div>
                        @endif
                    </div>
                        <img src="{!! asset('img/cupones/'.$cupon->imagen) !!}">

                    <div class="pdf-datos-cupon" style="opacity:0.8;">
                        <div class="pdf-tipo-descuento">
                            <p class="tipo">{!! $cupon->filtro->nombre !!}</p>
                        </div><div class="pdf-datos-descuento" >
                            <p class="pdf-cupon-titulo">{!! $cupon->titulo !!}</p>
                            <p class="pdf-cupon-descripcion">{!! $cupon->descripcion_corta !!}</p>
                        </div>      
                    </div>
                </div>  

            </div>

            <div class="texto-cupon">
                <p class="cupon-title">{!! $data['datos-cupon']->titulo !!}</p>
                <p>{!! $data['datos-cupon']->descripcion !!}</p>
                <p>{!! ($data['datos-cupon']->fecha_fin == '9999-12-31')? 'Ilimitado' : 'Válido hasta: '.fecha_formato_europeo($data['datos-cupon']->fecha_fin) !!}</p>
            </div>
        </div>
    </div>
    <div  class="pdf-body">
        <div class="line"></div>
        <div class="establecimientos">

                    @if($imagen == '')
                        <img src="{!! asset('/img/600x600.png') !!}" width="120px">
                    @else
                        <img src="{!! asset($imagen) !!}" width="120px">

                    @endif

            @foreach($data['datos-cupon']->tienda as $tienda)
            <div class="listado-tiendas">
                <p>{!! $tienda->nombre !!}</p>
                <p>{!! $tienda->direccion !!}</p>
                <p>Tlf: {!! $tienda->telefono !!}</p>             
            </div>
            @endforeach
        </div>  
        <div class="line"></div>
        <div class="qr-cupon">
            <p>Enseña este código promocional en el establecimiento y empieza a disfrutar:</p>
            <div class="qr">{!! DNS2D::getBarcodeHTML($tienda->id.'-'.$data['datos-cupon']->id.'-'.date('Y-m-d'), "QRCODE"); !!}</div>
        </div>
        <div class="line"></div>
        <div class="politicas">
            <p class="cupon-title">Política de privacidad:</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        </div>
    </div>

    <footer></footer>