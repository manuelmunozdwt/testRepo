@extends('layouts.app')

@section('content')
<div class="" id="content">

    <section class="container-fluid">
        <div class="row descuentos">
            <div class="col-xs-12  col-md-8 col-md-offset-2">
                @if(empty($data['incentiveItems']))
                    Lo sentimos, aún no existen cupones de descuento en esta categoría.
                @else
                    @foreach($data['incentiveItems']['incentiveItem'] as $cupon)
                        
                            <div class="promo">
                                <div class="brand">
                                    <div class="logo-blanco">
                                         {!! $cupon['program']['$'] !!}
                                    </div>
                                </div>
                                <a href="{!! route('cupon-descuento', $cupon['@id']) !!}">
                                    <img src="{!! asset('img/cupones/pizza.png') !!}">
                                </a>
                                <div class="datos-cupon">
                                    <div class="datos-descuento">
                                        <p class="cupon-titulo"><a href="{!! route('cupon-descuento', $cupon['@id']) !!}">{!! $cupon['name'] !!}</a></p>
                                    </div>      
                                </div>

                            </div>
     
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row ">
            <div id="voucherExampleCupon">
                <div id="voucherCupon" >
                   
                </div>
            </div>
        </div>
    </section>


</div>
@stop

@section('JSpage')

    <script type="text/javascript" src="{!! asset('js/tradedoubler-api.js') !!}"></script>

    <script type="text/javascript">
        function cupon(id){
            var from = 'td';
          //var cupon_id = id;
          //var url = "{!! url('/cupon-descuento/"+id+"')!!}";
          //window.location = "/ClubEnko/public/cupon-descuento/"+from+id;
          window.location = "{!! url('/cupon-descuento/"+from+id+"')!!}";
        }
    </script>
@endsection