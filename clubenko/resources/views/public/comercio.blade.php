@extends('layouts.app')

@section('content')
<div class="" id="content">
    <section class="container-fluid">
        <div class="row">
            <div class="col-xs-12 menu-categorias comercio">
                <div class="dropdown">
                    <p class="item-left">+</p>
                    
                        <a style="cursor: pointer" id="btn_2_{{$data['datos-tienda']->id}}" value="{{$data['datos-tienda']->id}}" class="text-error bold noboton like">
                              @if(!$data['datos-tienda']->tiene_like)
                                <span id="fav_2_{{$data['datos-tienda']->id}}"><img src="{!! asset('/img/favoritos-o.png') !!}"></span>
                              @else
                                <span id="fav_2_{{$data['datos-tienda']->id}}"><img src="{!! asset('/img/favoritos.png') !!}"></i></span>
                              @endif
                        </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container ">

        <div class="row">
            <div class="col-xs-12">
                <div class="logo imagen_container">
                    @if(($data['datos-tienda']->usuario()->first()->imagen) == "")
                    <img src="{!! asset('/img/600x600.png') !!}">
                    @else
                    <img src="{!! asset($data['datos-tienda']->usuario()->first()->imagen) !!}">
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 section-description">
                <p class="cupon-title">{!! $data['datos-tienda']->nombre !!}</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. </p><!-- implementar descripción de la empresa -->
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @foreach($data['cupones'] as $cupon)
                <div class="promo">
                    @include('includes.cupon')
                </div>
                @endforeach
            </div>

        </div>

    </section>

</div>
@stop

@section('JSpage')
<script>
    $(document).ready(function() {
       $('.like').click(function(){
        var id = ($(this).attr("id"));
          $.ajax({
          data: $(this).attr("id"),
          type: "GET",
          url: "{{route('like')}}",
          success: function(a) {
            //console.log(a)
                  if (a[3]) {
                    $('#fav_'+a[2]+'_'+a[0]).html("<img src='{!! asset('/img/favoritos.png') !!}'>");
                  }
                  else{
                    $('#fav_'+a[2]+'_'+a[0]).html("<img src='{!! asset('/img/favoritos-o.png') !!}'>");
                  }
          }
           });
       });
    });
</script>
@stop