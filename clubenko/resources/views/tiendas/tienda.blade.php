@extends('layouts.app')

@section('content')

{!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}
   
{!! Html::style('css/jquery-ui.css') !!}
{!! Html::style('css/jquery-ui.min.css') !!}
{!! Html::style('css/jquery-ui.structure.css') !!}
{!! Html::style('css/jquery-ui.structure.min.css') !!}
{!! Html::style('css/jquery-ui.theme.css') !!}
{!! Html::style('css/jquery-ui.theme.min.css') !!}

<div class="container" id="tiendas">
  <!-- Submenu comercio -->
  <div class="row">
      <div class="col-md-12">
          <div class="submenu-comercio">
              <ul class="submenu-item-list">
                  <a class="listado" href="{!! route('listar-tiendas', Auth::user()->slug) !!}"><li>MIS TIENDAS</li></a>
                  <a class="creacion" href="{!! route('tiendas.create') !!}"><li class="">NUEVA TIENDA</li></a>
              </ul>
              <div class="submenu-item-description">
                  <div class="edicion hidden">
                    <div class="promo">
                      <p>{!! $data['datos-tienda']->nombre !!}</p>
                      <p>{!! $data['datos-tienda']->direccion !!}</p>
                      <p>{!! $data['datos-tienda']->telefono !!}</p>
                      <p>{!! $data['datos-tienda']->web !!}</p>
                    </div>
                    <div class="enlaces">
                        <div class="editar"><a href="{!! route('tiendas.edit', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('borrar-tienda', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="row gris-oscuro">
    <div class="blue">
      <div class="col-md-5">
        <div class="datos-tienda">
          <div class="imagen-comercio">
          @if(Auth::user()->imagen == "")
            <img src="{!! asset('img/600x600.png') !!}">
          @else
            <img src="{!! asset(Auth::user()->imagen) !!}">
          @endif
          </div>
          <p>{!! $data['datos-tienda']->nombre !!}</p>
          <p>{!! $data['datos-tienda']->direccion !!}</p>
          <p>{!! $data['datos-tienda']->telefono !!}</p>
          <p>{!! $data['datos-tienda']->web !!}</p>
        </div>
      </div>
      <div class="col-md-7 mapa">
        <div id="map"></div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="datos-tienda">
        <p>Descripción de la tienda</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('JSpage')

  <script>
    var map;
    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: {!! $data['datos-tienda']->latitud !!}, lng: {!! $data['datos-tienda']->longitud !!}},
        zoom: 16
      });
    var marker = new google.maps.Marker({
      map: map,
      position: {lat: {!! $data['datos-tienda']->latitud !!}, lng: {!! $data['datos-tienda']->longitud !!}}
    });
    }
  </script>

    <script type="text/javascript">

    $('.listado li').addClass('active');
    $('div .listado').css('background', '#fff');
    $('div.edicion').removeClass('hidden');
    $('div.enlaces').css('float', 'right');
  </script>
@endsection
