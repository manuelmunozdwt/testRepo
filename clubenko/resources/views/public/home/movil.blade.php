@extends('layouts.app')

@section('content')

<div class="" id="content">
    <section class="container-fluid">
        <div class="row">
            <div class="col-xs-12 menu-categorias">
                <div class="slider">
                @foreach($data['categorias'] as $categoria)
                    <div>
                        <a href="{!! route('home_ver_categoria', $categoria->slug) !!}"><img src="{!! $categoria->imagen !!}"></a><div class="cat-nombre">{!! $categoria->nombre !!}</div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid ultimas-promos">
        <div class="row">
            <div class="col-xs-12 col-md-12 section-title">
                <p>Últimas promos</p>
            </div>
            <div id="carousel" class="carousel slide" data-ride="carousel">


              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                @foreach($data['bloques']->where('tipo', 'slide') as $slide)
                    @if ($slide->cupon)
                        <div class="item">
                            <div class="promo">
                                @include('includes.cupon', ['cupon' => $slide->cupon])
                            </div>
                        </div>
                    @endif
                @endforeach
              </div>
              
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>

            </div>
        </div>
    </section>

    <section class="container-fluid promos">
        <div class="row">
            <div class="col-xs-12 col-md-12 section-title">
                <p>Los más populares</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12  col-md-12" id="populares">
                @foreach($data['populares'] as $popular)
                    @if ($popular->cupon)
                        <div class="promo" data-id="popular-{!! $popular->id!!}" id="popular-{!! $popular->id!!}">
                            @include('includes.cupon', ['cupon' => $popular->cupon])
                        </div>
                    @endif
                    
                @endforeach
                <div id="populares_categoria" class="hidden">

                @foreach($data['bloques']->where('tipo', 'bloque') as $bloque)
                    <div class="promo">
                        <a href="{!! url('categorias', $bloque->enlace) !!}">
                            <p style='font-size:25px;text-align:center;position:absolute;background:rgba(255,255,255,0.8);width:100%;top:60px;padding:20px;'> {!! str_replace('-', ' ', ucfirst($bloque->enlace))!!} </p>
                            <img src="{!! asset($bloque->imagen) !!}">
                        </a>
                    </div>
                    @if($bloque->cupon_id != null)
                        @if ($bloque->cupon)
                            <div class="promo">
                                @include('includes.cupon', ['cupon' => $bloque->cupon->where('id', $bloque->cupon_id)->first()])
                            </div>
                        @endif
                    @endif
                    @if($bloque->cupon_id2 != null)
                        @if ($bloque->cupon)
                            <div class="promo">
                                @include('includes.cupon', ['cupon' => $bloque->cupon->where('id', $bloque->cupon_id2)->first()])
                            </div>
                        @endif
                    @endif
                @endforeach
                </div>
                <div class="promo" id="btn_ver_mas">
                    <p class="btn-comentario"  id="ver_bloques">+ Más</p>
                </div>
                <div class="promo hidden" id="btn_ver_menos">
                    <p class="btn-comentario"  id="ver_menos_bloques">- Menos</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid promos">
        <div class="row">
            <div class="col-xs-12 section-title">
                <p>Todas</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12  col-md-12">
                @foreach($data['cupones']->splice(1, 3) as $cupon)
                    <div class="promo">
                    @if (isset($cupon->precio))
                        <?php $promocion = $cupon; ?>
                        @include('includes.promocion')
                    @else
                        @include('includes.cupon')
                    @endif
                    </div>
                @endforeach

                <div class="collapse" id="collapseMasCupones">
                    @foreach($data['cupones']->splice(1, 50) as $cupon)
                        <div class="promo">
                            @if (isset($cupon->precio))
                                <?php $promocion = $cupon; ?>
                                @include('includes.promocion')
                            @else
                                @include('includes.cupon')
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="promo" id="btn_mas_cupones">
                    <p class="mas btn-comentario" id="mas-cupones">+ Más</p>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection

@section('JSpage')

    <script type="text/javascript">
        $('.caducado').parents('.promo').addClass('hidden');
        $('.caducado').parents('.item').remove();
        var activos = $('.carousel-inner .item').length-1;
        
        $('.carousel-indicators li:gt('+activos+')').remove();

        $('.item').first().addClass('active');

        $('#ver_bloques').on('click', function(){
            console.log('ver más bloques clicked');
            $('#btn_ver_mas').addClass('hidden');
            $("#populares_categoria").removeClass('hidden');
            $("#btn_ver_menos").removeClass('hidden');
        });

        $('#ver_menos_bloques').on('click', function(){
            console.log('ver menos bloques clicked');
            $('#btn_ver_mas').removeClass('hidden');
            $("#populares_categoria").addClass('hidden');
            $("#btn_ver_menos").addClass('hidden');
        });

       $('#mas-cupones').click(function(){
           $('#collapseMasCupones').collapse()
           $('#btn_mas_cupones').html('')
       });
       $('#menos-cupones').click(function(){
           alert('s')
           $('#collapseMasCupones').collapse('hide')
           $('#btn_mas_cupones').html('<p class="mas" id="mas-cupones">+ Más</p>')
       });


    </script>

@endsection