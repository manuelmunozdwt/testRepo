@extends('layouts.app')

@section('content')
<div class="" id="content">
    <section class="container-fluid">
        <div class="row">
            <div class="col-xs-12 heading-categoria">
                <div class="dropdown" id="subcategorias">

                    <p class="dropdown-toggle dropdown-subcategorias" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-plus" aria-hidden="true"></i></p>

                    <ul class="dropdown-menu arrow_box" aria-labelledby="dropdownMenu2">
                        @foreach($data['categoria']->subcategoria as $subcategoria)
                        <li id="{!! $subcategoria->id !!}"><span class="bullet"></span><a href="{!! route('subcategorias', $subcategoria->slug) !!}">{!! $subcategoria->nombre !!}</a></li>
                        @endforeach
                        <li id="{!! $data['categoria']->id !!}"><span class="bullet"></span><a href="{!! route('home_ver_categoria', $data['categoria']->slug) !!}">Todas</a></li>
                    </ul>
                </div>


                <div class="dropdown" id="filtros">

                    <p class="dropdown-toggle item-right" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Filtro</p>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">  
                        @foreach($data['filtros'] as $filtro)
                            <li id="filtro{!! $filtro->id!!}"><span class="bullet"></span><a href="{!! route('tipos', [$data['categoria']->slug, $filtro->id]) !!}">{!! $filtro->nombre !!}</a></li>
                        @endforeach

                    </ul>
                </div>
                <div class="imagen-categoria">
                    <div class="imagen-categoria-box">
                        <img src="{!! config('constantes.ruta_img').$data['categoria']->imagen !!}">
                        <p>{!! $data['categoria']->nombre !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">

        <div class="row ">
            <div class="col-xs-12  col-md-8 col-md-offset-2">
                @if($data['cupones']->isEmpty())
                    Lo sentimos, aún no existen cupones de descuento en esta categoría.
                @else
                    @foreach($data['cupones'] as $cupon)
                    <div class="promo">
                        @include('includes.cupon')
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </section>
</div>

@stop

@section('JSpage')

<script type="text/javascript">

    $('#'+{!!$data['categoria']->id !!}+' .bullet').addClass('active');    


    $('#filtros li').on('click', function(){
         $(this).addClass('active');

    });
    $('#filtro'+{!! $data['id'] !!}+' .bullet').addClass('active');


</script>
@stop