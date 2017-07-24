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
                    <a class="listado" href="{!! route('listar-cupones', Auth::user()->slug) !!}"><li>LISTADO DE MIS CUPONES</li></a>
                    <a class="creacion" href="{!! route('cupones.create') !!}"><li class="">NUEVO CUPÓN</li></a>
                    <a class="edicion" href=""><li></li></a>
                </ul>
                <div class="submenu-item-description">
                    <div class="listado hidden">
                        <p>EL listado de tus cupones te permite ver todo el histórico de cupones de tu comercio. Pincha en el cupón si quieres editarlo, duplicarlo o borrarlo.</p>
                        <div class="iconos-listados">
                            <div class="iconos"><a class="" href="{!! route('listar-cupones', Auth::user()->slug) !!}"><img src="{!! asset('img/logo-enko-activos-A.png') !!}"><span>Activos</span></a></div>
                            <div class="iconos"><a class="" href="{!! route('listar-cupones-caducados', Auth::user()->slug) !!}"><img src="{!! asset('img/caducados-W.png') !!}"><span class='activo'>Caducados</span></a></div>
                            <div class="iconos"><a class="" href="{!! route('listar-cupones-programados', Auth::user()->slug) !!}"><img src="{!! asset('img/programados.png') !!}"><span>Programados</span></a></div>
                        </div>
                    </div>

                    <p class="creacion hidden">Crea y genera cupones y ofertas para tu comercio fácilmente. Puedes generar todos los cupones que quieras. Selecciona el local al que se aplica la oferta o cupón y en qué categoría quieres que se ubique.</p>

                </div>
            </div>
        </div>
    </div>
    <div class="row gris-oscuro">
         {!! Form::open([
            'method' => 'POST',
            'route' => 'buscar-caducados',
        ]) !!}   
        <div class="col-md-10">
        {!! Form::text('busqueda', '', ['class' => 'form-buscador']) !!}
        </div>
        <div class="col-md-2">
            {!! Form::submit('Buscar', ['class' => 'btn btn-blue']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    {{--@if(Auth::user()->cupon()->first() == '' | $data['cupones-caducados']->first() == '')        
        <div class="row">
            <div class="col-md-12">
                <div class="blanco">
                    <p>Aún no tiene ningún cupón.</p>
                </div>
            </div>
        </div>
    @endif

    @foreach ($data['cupones-caducados']->chunk(4) as $chunk)
        <div class="row gris">
            @foreach ($chunk as $cupon)
            <div class="col-md-3">
                <p>{!! $cupon->tienda()->first()->usuario()->first()->name !!}</p>

                <div class="promo">
                    <a href="">
                        @include('includes.cupon')
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endforeach--}}
    @include('dashboard.cupones.resultado-cupones')

</div>


<div class="container">
    <div class="row gris" id="voucherExampleCupon">
        <div id="voucherCupon" >
           
        </div>
    </div>
</div>

@endsection

@section('JSpage')

  <script type="text/javascript">
    $('.listado li').addClass('active');
    $('p.listado').removeClass('hidden');
    $('div.listado').removeClass('hidden');
  </script>

@endsection