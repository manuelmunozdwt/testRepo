@extends('layouts.app')

@section('CSSHeader')


@section('content')
<div class="container">

    <div class="row">
        <div class="col-xs-12">
        	<div class="atras">
                <a href="{!! URL::previous() !!}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
        	<div class="promo">
        	@if($data['cupon']->imagen == '')
        		<img src="{!! asset ('/img/icono_user.png') !!}" width="120px">
        	@else
        		@include('includes.cupon',['cupon' => $data['cupon']])
        	@endif
        	</div>
        </div>
    </div>
	<div class="row oferta m-b-20">
    	<div class="col-xs-12 social col-md-12 m-b-10">
            <div id="cont_1_{{$data['cupon']->id}}" class="like-objeto iconos-cupon">{{$data['cupon']->likes}} personas les gusta</div>
            @if(Auth::check())
                <div class='iconos-cupon'>
                    <a style="cursor: pointer" id="btn_1_{{$data['cupon']->id}}" value="{{$data['cupon']->id}}" class="text-error bold noboton like">
                      @if(!$data['cupon']->tiene_like)
                        <span id="heart_1_{{$data['cupon']->id}}"><i class="fa fa-heart-o  m-r-10"></i></span>
                      @else
                        <span id="heart_1_{{$data['cupon']->id}}"><i class="fa fa-heart  m-r-10"></i></span>
                      @endif
                      </a>
                    
                </div>
            @endif
            <div class='iconos-cupon'>
                <a href="#comentarios"><i class="fa fa-comments-o" aria-hidden="true"></i></a>
            </div>
            <div class='iconos-cupon'>
                <a href="#ubicacion"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
            </div>
    	</div>

    </div>
    <div class="row">
    	<div class="col-xs-12  col-md-4 col-md-offset-4 section-title">
            <p>Detalles de la oferta</p>
        </div>

    	<div class="col-xs-12  col-md-4 col-md-offset-4 section-description">


            <p class="cupon-title">{!! $data['cupon']->titulo !!}</p>
            <p>{!! $data['cupon']->descripcion !!}</p>
    	</div>

        <div class="col-xs-12  col-md-4 col-md-offset-4">
            <div class="otras">
                <span>Ver más ofertas de: </span><span>
                @if($data['cupon']->tienda->first()->usuario()->first()->imagen == '')
                    <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}"><img src="{!! asset('/img/600x600.png') !!}" width="120px"></a>      
                @else
                    <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}"><img src="{!! asset($data['cupon']->tienda->first()->usuario()->first()->imagen) !!}" width="120px"></a>
                @endif
                </span>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-xs-12 col-md-12 section-title">
            <p>Condiciones</p>
        </div>

        <div class="col-xs-12 section-description">
            {!! $data['cupon']->condiciones !!}

            @if ($data['cupon']->fecha_fin != '9999-12-31')
                <p>Esta oferta caduca el {!! fecha_formato_europeo($data['cupon']->fecha_fin) !!}</p>

            @else
                Ilimitado!
            @endif

           
   		</div>
    </div>
    <div class="row" id="comentarios">
    	<div class="col-xs-12 col-md-12 section-title">
            <p><i class="fa fa-comments-o" aria-hidden="true"></i>   Comentarios ({!! count($data['comentarios']) !!})</p>
        </div>
        @if(empty($data['comentarios']->first()))
            <div class="col-xs-12 section-description">
                <div class="row comentario">
                    <p>Todavía no existen comentarios en esta oferta. ¡Sé el primero en dejarnos tu opinión!</p>
                </div>
            </div>

        @else
            @foreach($data['comentarios']->splice(0, 4) as $comentario)
            <div class="col-xs-12 section-description">
                <div class="row comentario">
                    <div class="col-xs-3 autor">
                        @if($comentario->usuario->imagen == null)
                        <img  src="{!! asset ('/img/icono_user.png') !!}">
                        @else
                         <img class="imagen_usuario" src="{!! asset ($comentario->usuario->imagen) !!}">
                        @endif
                        <p class="nombre">{!! $comentario->usuario->name!!}</p>
                    </div>
                    <div class="col-xs-9 comment">
                        {!! $comentario->comentario !!}
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-xs-12 section-description">
                <a href="{!! route('lista-comentarios', $data['cupon']->slug) !!}" class="btn-comentario"> Ver + </a>
            </div>   
        @endif
        <div class="col-xs-12">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>

        @elseif ($errors->has('comentario'))
            <span class="help-block">
                <strong>{!! $errors->first('comentario') !!}</strong>
            </span>
        @endif
        @if ($data['comentario_existe'] == null) 
            @if(Auth::check())
            <div class="form-group">
                {!! Form::open(['route' => 'comentarios.store']) !!}
                {!! Form::hidden('cupon_id', $data['cupon']->id) !!}
                {!! Form::text('comentario', '', array('class' => 'form-control', 'placeholder' => 'Deja tu comentario')) !!}
                {!! Form::submit( 'Enviar', array('class' => 'btn-comentario'))!!}
                {!! Form::close() !!}
            </div>
            @else
            <div class="form-group">
                <p class="form-control"><a href="{!! route('login') !!}">Conéctate para dejar un comentario</a></p>
            </div>
            @endif
        @endif
        </div>
    </div>
    <div class="row" id="ubicacion">
    	<div class="col-xs-12 col-md-12 section-title">
            <p><i class="fa fa-map-marker" aria-hidden="true"></i>   Ubicación</p>
        </div>
        @if(count($data['cupon']->tienda) > 1)
        	@foreach($data['cupon']->tienda as $tienda)
            <div class="col-xs-12">
                <p>{!! $tienda->nombre !!}</p>
                <p>{!! $tienda->direccion !!}</p>
                <p>{!! $tienda->telefono !!}</p> <!-- pendiente insertar telefono en bbdd-->
                <p>{!! $tienda->web !!}</p> <!-- pendiente insertar telefono en bbdd-->
            </div>
            <hr>
            {{--<div id="map"></div>--}}            
            @endforeach
        @elseif(count($data['cupon']->tienda) == 1)
            @foreach($data['cupon']->tienda as $tienda)
            <div class="col-xs-12">
                <p>{!! $tienda->nombre !!}</p>
                <p>{!! $tienda->direccion !!}</p>
                <p>{!! $tienda->web !!}</p> <!-- pendiente insertar telefono en bbdd-->
                <div id="map"></div>
            </div>
            @endforeach

        @endif
        <div class="col-xs-12 col-md-12 section-description">
            <div class="ubicacion">
        	</div>
        </div>
    </div>
</div>

@endsection

@section('footer-html')

<div class="row">
  <div class="col-xs-12 col-md-12 section-title">
      <div class="descargar">
        @if($data['cupon']->fecha_fin < $now)
            <p>Cupón caducado</p>
        @else       
            <a href="{!! url('cupon-pdf', $data['cupon']->slug) !!}" class="descargar" >Quiero esta oferta &nbsp;&nbsp; <i class="fa fa-arrow-down" aria-hidden="true"></i></a></span>
        @endif
      </div>
  </div>
</div>
@endsection

@section('JSpage')
  <script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: {!! $tienda->latitud !!}, lng: {!! $tienda->longitud !!}},
            zoom: 16
        });
        var marker = new google.maps.Marker({
          map: map,
          position: {lat: {!! $tienda->latitud !!}, lng: {!! $tienda->longitud !!}}
        });
    }
  </script>

  <script>
        //Slider cupón
  jQuery(document).ready(function($) {
 
        $('#myCarousel').carousel({
                interval: 5000
        });
 
        $('#carousel-text').html($('#slide-content-0').html());
 
        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click( function(){
                var id_selector = $(this).attr("id");
                var id = id_selector.substr(id_selector.length -1);
                var id = parseInt(id);
                $('#myCarousel').carousel(id);
        });
 
 
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid', function (e) {
                var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
        });
});
  </script>
@endsection