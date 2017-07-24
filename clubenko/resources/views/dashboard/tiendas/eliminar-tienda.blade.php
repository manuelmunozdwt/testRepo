@extends('layouts.app')

@section('content')

{!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}
   
{!! Html::style('css/jquery-ui.css') !!}
{!! Html::style('css/jquery-ui.min.css') !!}
{!! Html::style('css/jquery-ui.structure.css') !!}
{!! Html::style('css/jquery-ui.structure.min.css') !!}
{!! Html::style('css/jquery-ui.theme.css') !!}
{!! Html::style('css/jquery-ui.theme.min.css') !!}

<div class="container">
    <!-- Submenu comercio -->
    <div class="row" id="tiendas">
        <div class="col-md-12">
          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
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
                        <div class="editar"><a href="{!! route('tiendas.edit', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('borrar-tienda', $data['datos-tienda']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
    <!-- Fin submenu comercio -->
        <!-- Formulario -->
   {!! Form::model($data['datos-tienda'],[
        'method' => 'DELETE',
        'route' => ['tiendas.destroy', $data['datos-tienda']->slug],
    ]) !!}   
    <div class="row gris-oscuro botones">
        <div class="col-md-12">
            {!! Form::submit('Eliminar tienda', array('class' => 'btn-blue'))!!}
            <p class="delete-title">Eliminar permanentemente esta tienda</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('JSpage')

  <script type="text/javascript">

    $('.edicion li').addClass('active');
    $('div .borrar').css('background', '#fff');
    $('div.edicion').removeClass('hidden').css('float', 'right');
  </script>

@endsection