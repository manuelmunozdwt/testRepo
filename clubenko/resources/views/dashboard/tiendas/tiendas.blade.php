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
    <div class="row">
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
                    <a class="edicion" href=""><li></li></a>
                </ul>
                <div class="submenu-item-description">
                    <p class="listado hidden">Mis tiendas te permite ver todas las tiendas que tienes en tu comercio para poder asociarlas a tus cupones. puedes pinchar en cualquiera de ellas para ver más información, editarlas o borrarlas.</p>

                    <p class="creacion hidden">Crea una nueva tienda. Tus cupones podrán usarse en cualquiera de las tiendas que tenga tu comercio.</p>

                    <p class="edicion"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin submenu comercio -->
    <div class="row gris"></div>
        <!-- Formulario -->
    <div class="row">
        <div class="col-md-12">
            <div class="imagen-comercio">
            @if(Auth::user()->imagen == "")
                <img src="{!! asset('img/600x600.png') !!}">
            @else

                <img src="{!! asset(Auth::user()->imagen) !!}">
            @endif
            </div>

        </div>
    </div>

    @if($data['tiendas']->first()==null)        
        <div class="row">
            <div class="col-md-12">
                <div class="blanco">
                    <p>Aún no tiene ninguna tienda registrada. Por favor, registre una tienda antes de crear nuevos cupones.</p>
                </div>
            </div>
        </div>
    @endif

    @foreach ($data['tiendas']->chunk(4) as $chunk)
    <div class="row listado-tiendas-comercio">
        @foreach ($chunk as $tienda)
        <div class="col-md-3 tiendas">
            <a href="{{ route('tiendas.show', $tienda->slug) }}">
                <p class="gris">{!! $tienda->nombre !!}</p>
                <p>{!! $tienda->direccion !!}</p>
                <p>{!! $tienda->telefono !!}</p>
                <p>{!! $tienda->web !!}</p>
            </a>
        </div>
        @endforeach
    </div>
    @endforeach

</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.listado li').addClass('active');
    $('p.listado').removeClass('hidden');
  </script>
@endsection
