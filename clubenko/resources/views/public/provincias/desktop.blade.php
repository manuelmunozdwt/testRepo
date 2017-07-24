@extends('layouts.public-desktop')

@section('title') {!! Config::get('constantes.cliente') !!} @endsection

@section('CSSHeader')

{!! Html::style('css/public/desktop-style.css') !!}

@endsection

@section('content')

<section id="ls-in-app-messages"><div class="row">
  <div id="in-app-messages" class="twelve column" >
    <div class="in-app-msg-banner">
      @if ($data['banner-cabecera'])
        <a href="{!! $data['banner-cabecera']->enlace !!}"><img src="{!! asset($data['banner-cabecera']->imagen) !!}" alt="{!! $data['banner-cabecera']->alt !!}"></a>
      @endif
      
      <span id="ls-close-72929-link" >
        <a href="#" class="hide-link" aria-label="Cerrar"></a>
      </span>
    </div>
  </div>
</div>
</section>

<section class="main">
<div class="row container">
  <div class="two-col-nav">
    <div id="pull-page-header" class="page-header twelve column">
      <div>
        <h1 class="title" id="pull-page-header-title">
        <div>
          {!! $data['provincia']->nombre !!}
        </div>
        </h1>
      </div>
      <div class="dotted-line"></div>
    </div>

<section class="four-pack deal-pack row pad-row mm-widget">
        <div class="section-head">
          <h2>Nuevas ofertas</h2>
        </div>
        <div class="block-grid four-up">
          
        @foreach ($data['cupones'] as $cupon)
           <figure class="deal-card">
            <a href="{!! route('home_ver_cupon',$cupon->slug) !!}">
              <img class="" src="{!! asset('img/cupones') !!}/{!! $cupon->imagen !!}" alt="{!! $cupon->descripcion_corta !!}" title="{!! $cupon->descripcion_corta !!}">
              <figcaption>
                <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $cupon->titulo !!}</p>
                  <p class="merchant-name should-truncate" >
                    {!! $cupon->descripcion_corta !!}
                  </p>
                  <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  @if ($cupon['tienda']->count() > 1)
                    Varias tiendas
                  @else
                    {!! @$cupon['tienda'][0]->direccion !!}
                  @endif
                  </p>
                <div class="pricing">
                  <p class="deal-price very-long  ">

                    <span class="deal-from">Tu descuento</span> {!! $cupon->filtro->nombre !!}
                  </p>
                </div>
              </figcaption>
            </a>
          </figure>
        @endforeach

  </div>
</section>   

@if ($data['cupones']->links())
  <div id="pull-pagination">
  <div class="pagination-container" data-bhw="BrowsePaginationLinks" data-bhw-path="BrowsePaginationLinks">
    {{ $data['cupones']->links() }}

          <a rel="prev" href="{!! $data['cupones']->previousPageUrl() !!}" class="previous c-bg-prim ch-bg-prim-dk c-txt-white">
            <i class="fa fa-chevron-left" aria-hidden="true" style="margin-right: 10px;"></i> Anterior
          </a>
    

    
            <a rel="next" href="{!! $data['cupones']->nextPageUrl() !!}" class="next c-bg-prim ch-bg-prim-dk c-txt-white">
              Siguiente<i class="fa fa-chevron-right" aria-hidden="true" style="margin-left: 10px;"></i>
            </a>
  
<p class="results c-txt-gray-md">
<span><strong>{!! $data['cupones']->firstItem() !!} - {!! $data['cupones']->lastItem() !!}</strong> de {!! $data['cupones']->total() !!} resultados</span>

</p>

</div>

</div>
@endif

</div>
</div>
</section>
@endsection


@section('JSpage')


@endsection