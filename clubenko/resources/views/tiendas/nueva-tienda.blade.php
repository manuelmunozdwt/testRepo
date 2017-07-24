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
                    <a class="edicion" href=""><li></li></a>
                </ul>
                <div class="submenu-item-description">
                    <p class="listado hidden">Mis tiendas te permite ver todas las tiendas que tienes en tu comercio para poder asociarlas a tus cupones. puedes pinchar en cualquiera de ellas para ver más información, editarlas o borrarlas.</p>

                    <p class="creacion hidden">Crea una nueva tienda. Tus cupones podrán usarse en cualquiera de las tiendas que tenga tu comercio.</p>


                </div>
            </div>
        </div>
    </div>
    <div class="row gris-oscuro form">
        <div class="col-md-5">
           {!! Form::open(array('route' => 'tiendas.store', 'files' => true, 'id' => 'form')) !!}
              <input type="text" class="hidden" id="longitud" name="longitud" value="">
              <input type="text" class="hidden" id="latitud" name="latitud" value="">
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  {!! Form::label('nombre', 'Nombre', array('class', 'control-label')) !!}
                  {!! Form::text('nombre', '' , array('class' => 'form-control', 'required' => 'required')) !!}
              </div>

              <div class="form-group">
                  {!! Form::label('direccion', 'Dirección', ['class', 'control-label']) !!}
                  {!! Form::text('direccion', '', array('class'=> 'form-control', 'id' =>'address', 'required' => 'required')) !!}
              </div>

              <div class="form-group">
                  {!! Form::label('provincia', 'Provincia', ['class', 'control-label']) !!}
                  <select name="provincia_id" required="" class="form-control">
                    <option value="" disabled="" selected="">Seleccione una provincia</option>
                    <optgroup label="-------------------">
                      <option value="0">Internacional</option>
                    </optgroup>
                    <optgroup label="-------------------">
                    </optgroup>
                    @foreach ($data['provincias'] as $provincia)
                      <option value="{!! $provincia->id !!}">{!! $provincia->nombre !!}</option>
                    @endforeach
                  </select>
              </div>


              
              <div class="form-group">
                  {!! Form::label('telefono', 'Teléfono', ['class', 'control-label']) !!}
                  {!! Form::text('telefono', '', array('class'=> 'form-control', 'id' =>'telefono', 'required' => 'required')) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('web', 'Página Web', ['class', 'control-label']) !!}
                  {!! Form::text('web', '', array('class'=> 'form-control','id' =>'web')) !!}
              </div>

        </div>
        <div class="col-md-7">
          <div id="map"></div>
        </div>
    </div>
    <div class="row botones">
      <div class="col-md-12">
        <div class="blanco">
          @if (count($errors) > 0)
              <div class="alert alert-success">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          {!! Form::submit('Crear tienda', array('class' => 'btn-blue', 'id' => 'btn_submit'))!!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>

@endsection
@section('JSpage')

<script type="text/javascript">
    $(document).ready(function() {
        $('#form').submit(function(e) {
            var form = this;
            e.preventDefault();

            setTimeout(function () {
                form.submit();
            }, 500); // in milliseconds
        });
    });

    function initMap() {
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: {lat: 40.397, lng: -3.644}
          });
          var geocoder = new google.maps.Geocoder();

          $('#btn_submit').click(function(){
            geocodeAddress(geocoder, map);

          });
          
          var input = (document.getElementById('address'));

          var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
          var infowindow = new google.maps.InfoWindow();
          var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
          });
              autocomplete.addListener('place_changed', function() {
          
         // infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });
              
        }

        function geocodeAddress(geocoder, resultsMap) {
          var address = document.getElementById('address').value;
          geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
              var longitud = document.getElementById('longitud').setAttribute('value',results[0].geometry.location.lng());
              var latitud = document.getElementById('latitud').setAttribute('value',results[0].geometry.location.lat());

            } else {
              //alert('Geocode no tuvo éxito debido a: ' + status);
            }
          });
        }


      
    </script>

  <script type="text/javascript">
    $('.creacion li').addClass('active');
    $('p.creacion').removeClass('hidden').css('margin-top', '50px');
  </script>

@endsection