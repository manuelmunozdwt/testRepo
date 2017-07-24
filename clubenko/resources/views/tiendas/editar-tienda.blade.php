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
                    <a class="edicion" href=""><li>EDITAR MIS TIENDAS</li></a>
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
                            <div class="editar"><a href="{!! route('tiendas.edit', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('tiendas.destroy', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gris-oscuro">
      <div class="col-md-5">
        {!! Form::model($data['datos-tienda'], [
            'method' => 'PATCH',
            'route' => ['tiendas.update', $data['datos-tienda']->slug],
            'files' => true
        ]) !!} 

            <input type="text" class="hidden" id="longitud" name="longitud" value="{!! $data['datos-tienda']->longitud !!}">
            <input type="text" class="hidden" id="latitud" name="latitud" value="{!! $data['datos-tienda']->latitud  !!}">            

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('nombre', 'Nombre', array('class', 'control-label')) !!}
                {!! Form::text('nombre', $data['datos-tienda']->nombre , array('class' => 'form-control',  'placeholder' => 'Nombre')) !!}
                <div class="col-md-6">

                    @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('direccion', 'Dirección', ['class' => 'control-label', 'id']) !!}
                {!! Form::text('direccion', $data['datos-tienda']->direccion, array('class'=> 'form-control', 'id' => 'address')) !!}
            </div>

            <div class="form-group">
                  {!! Form::label('provincia', 'Provincia', ['class', 'control-label']) !!}
                  <select name="provincia_id" required="" class="form-control">
                    <option value="" disabled="" selected="">Seleccione una provincia</option>
                    <optgroup label="-------------------">
                      <option value="0" @if($data['datos-tienda']->provincia_id == '0') selected @endif>Internacional</option>
                    </optgroup>
                    <optgroup label="-------------------">
                    </optgroup>
                    @foreach ($data['provincias'] as $provincia)
                      <option value="{!! $provincia->id !!}" @if($data['datos-tienda']->provincia_id == $provincia->id) selected @endif>{!! $provincia->nombre !!}</option>
                    @endforeach
                  </select>
              </div>

            <div class="form-group">
                {!! Form::label('telefono', 'Teléfono', ['class', 'control-label']) !!}
                {!! Form::text('telefono', $data['datos-tienda']->telefono, array('class'=> 'form-control', 'id' =>'telefono')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('web', 'Página Web', ['class', 'control-label']) !!}
                {!! Form::text('web', $data['datos-tienda']->web, array('class'=> 'form-control','id' =>'web')) !!}
            </div>
      </div>
      <div class="col-md-7">
        <div id="map"></div>
      </div>
    </div>
    <div class="row botones">
      <div class="col-md-12">
        <div class="blanco">
                {!! Form::submit('Guardar datos', array('class' => 'btn-blue'))!!}
            {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>

@endsection
@section('JSpage')

  <script>
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: {lat: {!! $data['datos-tienda']->latitud !!}, lng: {!! $data['datos-tienda']->longitud !!}}
      });
    var marker = new google.maps.Marker({
      map: map,
      position: {lat: {!! $data['datos-tienda']->latitud !!}, lng: {!! $data['datos-tienda']->longitud !!}}
    });
      var geocoder = new google.maps.Geocoder();

      $('#submit').click( function() {
        geocodeAddress(geocoder, map);
      });
    }

    function geocodeAddress(geocoder, resultsMap) {
      var address = document.getElementById('address').value;
      geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          resultsMap.setCenter(results[0].geometry.location);
         
          var longitud = document.getElementById('longitud').setAttribute('value',results[0].geometry.location.lng());
          var latitud = document.getElementById('latitud').setAttribute('value',results[0].geometry.location.lat());

        } else {
          alert('Geocode was not successful for the following reason: ' + status);
        }
      });
    }
  </script>

  <script type="text/javascript">

    $('.edicion li').addClass('active');
    $('div .editar').css('background', '#fff');
    $('div.edicion').removeClass('hidden').css('float', 'right');
  </script>


@endsection