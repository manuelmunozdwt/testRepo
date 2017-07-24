@extends('layouts.app')

@section('content')
<div class="" id="content">

    <section class="container" id="mi-cuenta">

        <div class="row">
            <div class="col-xs-12 section-title usuario">
                <p>Mis cupones</p>
            </div>
        </div>

        <div class="row">
            
            @if($data['cupones']->isEmpty())
                Aún no tienes ningún cupón. ¡Descárgate alguno y empieza a disfrutar de nuestras mejores ofertas!
            @else
                @foreach($data['cupones'] as $cupon)
                    <div class="col-sm-4 mis-cupones">
                        <div class="promo">
                            @include('includes.cupon')
                        </div>
                    </div>
                @endforeach
            @endif
            
        </div>

    </section>

</div>
@stop

@section('JSpage')

@stop