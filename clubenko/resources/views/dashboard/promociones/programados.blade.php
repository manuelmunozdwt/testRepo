@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="submenu-comercio">
                <ul class="submenu-item-list">
                    <a class="listado" href="{!! route('listar-promociones', Auth::user()->slug) !!}"><li>LISTADO DE MIS PROMOCIONES</li></a>
                    <a class="creacion" href="{!! route('promociones.create') !!}"><li class="">NUEVA PROMOCIÓN</li></a>
                    <a class="edicion" href=""><li></li></a>
                </ul>
                <div class="submenu-item-description">
                    <div class="listado hidden">
                        <p>El listado de tus promociones te permite ver todo el histórico de promociones de tu comercio. Pincha en el cupón si quieres editarlo, duplicarlo o borrarlo.</p>
                        <div class="iconos-listados">
                            <div class="iconos"><a class="" href="{!! route('listar-promociones', Auth::user()->slug) !!}"><img src="{!! asset('img/logo-enko-activos-A.png') !!}"><span>Activas</span></a></div>
                            <div class="iconos"><a class="" href="{!! route('listar-promociones-caducados', Auth::user()->slug) !!}"><img src="{!! asset('img/caducados.png') !!}"><span>Caducadas</span></a></div>
                            <div class="iconos"><a class="" href="{!! route('listar-promociones-programados', Auth::user()->slug) !!}"><img src="{!! asset('img/programados-W.png') !!}"><span class='activo'>Programadas</span></a></div>
                        </div>
                    </div>

                    <p class="creacion hidden">Crea y genera promociones y ofertas para tu comercio fácilmente. Puedes generar todos los promociones que quieras. Selecciona el local al que se aplica la oferta o promoción y en qué categoría quieres que se ubique.</p>

                </div>
            </div>
        </div>
    </div>
    <div class="row gris-oscuro">
         {!! Form::open([
            'method' => 'POST',
            'route' => 'buscar-promocion',
        ]) !!}   
        <div class="col-md-10">
        {!! Form::text('busqueda', '', ['class' => 'form-buscador']) !!}
        </div>
        <div class="col-md-2 ">
            {!! Form::submit('Buscar', ['class' => 'btn btn-blue']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @include('dashboard.promociones.resultado-promociones')

</div>


@endsection

@section('JSpage')
   
  <script type="text/javascript">
    $('.listado li').addClass('active');
    $('p.listado').removeClass('hidden');
    $('div.listado').removeClass('hidden');

    $('.brand a').removeAttr('href');
  </script>


@endsection