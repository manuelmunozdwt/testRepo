@extends('layouts.public-desktop')

@section('title') {!! Config::get('constantes.cliente') !!} @endsection

@section('CSSHeader')

{!! Html::style('css/public/desktop-style.css') !!}

<style type="text/css">
  
  .original-price{
        font-size: 16px;
    color: #888;
    text-decoration: line-through;
  }
</style>

@endsection

@section('content')
<section id="ls-in-app-messages"><div class="row">
  <div id="in-app-messages" class="twelve column" >
    <div class="in-app-msg-banner">
      @if ($data['banner-cabecera'])
        <a href="{!! $data['banner-cabecera']->enlace !!}"  target="_blank"><img src="{!! asset($data['banner-cabecera']->imagen) !!}" alt="{!! $data['banner-cabecera']->alt !!}"></a>
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
          {!! $data['categoria']->nombre !!}
        </div>
        </h1>
      </div>
      {{-- <div class="dotted-line"></div> --}}
      <div class="card-ui cui-c-deal cui-c-deal-featured v1" style="border-bottom: solid 1px#e6e7e8!important; margin-top:10px">

    </div>
    </div>
    
    <div id="pull-side-bar" class="three columns">
      
      <div id="refinement-ui" style="padding-top: 0px;">  
        <div class="refinement-box">
          <div class="refinement-box">
            <h4 style="margin-top: 0px;">Categorías</h4>
            <ul class="refinement-list">
              <li class="refinement">
                <span>
                  <span class="refinement-name selected dynamic">
                    <label class="name truncated">
                      <a href="{!! route('home_ver_categoria',$data['categoria']->slug) !!}">{!! $data['categoria']->nombre !!}</a>
                      <span class="deal-counts">({!! $data['categoria']->activos !!})</span>
                      
                    </label>
                  </span>
                </span>
                
                <ul class="children-list lowest-selected expanded">
                  @foreach ($data['subcategorias'] as $subcategoria)
                    <li class="refinement">
                    @if (isset($data['data_subcategoria']) && ($data['data_subcategoria']->slug == $subcategoria->slug))
                      <span class="refinement-name dynamic selected">
                    @else
                      <span class="refinement-name dynamic">
                    @endif
                      
                        <label class="name truncated" for="ref-ui-checkbox-restaurante">
                          <a href="{!! route('home_ver_subcategorias',[$data['categoria']->slug,$subcategoria->slug]) !!}">{!! $subcategoria->nombre !!}</a>
                          <span class="deal-counts">({!! $subcategoria->cupones_activos->count() !!})</span>
                        </label>
                      </span>
                    </li>
                  @endforeach
                </ul>

                @if ($data['categoria']->banner_categoria != '')
                  <div>
                    <a href="{{ $data['categoria']->banner_enlace }}" target="_blank">
                      <img src="{{ asset($data['categoria']->banner_categoria) }}" alt="{{ $data['categoria']->banner_alt }}" title="{{ $data['categoria']->banner_alt }}">
                    </a>
                  </div>
                @endif
                
                
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

<div id="pull-results" class="nine columns">

<div id="pull-cards" class="cui-two-up cui-xlarge-three-up cui-large-two-up cui-medium-two-up cui-480-one-up">

@if ($data['cupon_superior'])
  <figure class="card-ui cui-c-deal cui-c-deal-featured v1">

      <div class="cui-image-container">
        <a href="{!! route('home_ver_cupon',$data['cupon_superior']->slug) !!}">
          <div class="cui-bg-image " style="background-image: url({!! asset('img/cupones') !!}/{!! $data['cupon_superior']->imagen !!})" alt="{!! $data['cupon_superior']->titulo !!}" title="{!! $data['cupon_superior']->titulo !!}">
            <p style="display:none">{!! $data['cupon_superior']->descripcion_corta !!}</p>
          </div>
        </a>
      </div>
      <figcaption>

        <h3 class="cui-title">
        <a class="cui-url c-txt-black should-truncate" href="" style="word-wrap: break-word;">{!! $data['cupon_superior']->titulo !!}</a>
        </h3>
        <div class="cui-description c-txt-gray-md">
        <p>{!! $data['cupon_superior']->descripcion_corta !!}</p>
        </div>
        <div class="cui-location cui-truncate c-txt-gray-dk cui-has-distance">
        <span class="cui-location-name ">

          @if ($data['cupon_superior']->count() > 1)
            Varias tiendas
          @else
            {!! @$data['cupon_superior'][0]->direccion !!}
          @endif

        </span>
        </div>

        <div class="cui-price-promotions-container">
          <div class="cui-price" data-pingdom-id="deal-price">
            <span class="cui-price-discount c-txt-price">
              <span class="cui-price-descriptor">
                <span class="cui-price-descriptor">Tu descuento </span>
              </span>
              {!! $data['cupon_superior']->filtro->nombre !!}
            </span>
          </div>
        </div>
        <div class="cui-view-deal">
        <a href="{!! route('home_ver_cupon',$data['cupon_superior']->slug) !!}" class="btn">
        Ver oferta
        </a>
        </div>
      </figcaption>

  </figure>
  <div class="card-ui cui-c-deal cui-c-deal-featured v1">
    <div style="border-bottom: solid 1px#e6e7e8!important;"></div>
  </div>
@endif

@foreach ($data['cupones'] as $cupon)

  <figure class="card-ui cui-c-deal v1">
    <div class="cui-content c-bg-gray-bg">
      <a href="{!! $cupon->url !!}">
        <div class="cui-image-container">
          <div class="cui-image-lazy-container">
            <img class="cui-svg-placeholder c-bg-gray-bg" type="image/svg+xml" height="279" width="460" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' height='279' width='460'%2F%3E" alt="image placeholder">
            <img class="cui-image is-lazyloaded" src="{!! asset('img/cupones') !!}/{!! $cupon->imagen !!}" data-original="{!! asset('img/cupones') !!}/{!! $cupon->imagen !!}" data-high-quality="{!! asset('img/cupones') !!}/{!! $cupon->imagen !!}" alt="{!! $cupon->titulo !!}" title="{!! $cupon->titulo !!}">
          </div>
        </div>
        <figcaption>
          <p class="cui-deal-title c-txt-black should-truncate" style="word-wrap: break-word;">{!! $cupon->titulo !!}</p>
          <div class="cui-details-container">
            <div class="cui-merchant-name c-txt-gray-dk cui-truncate">
              {!! $cupon->descripcion_corta !!}
            </div>
            <div class="cui-location cui-truncate c-txt-gray-dk cui-has-distance">
              <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                @if ($cupon['tienda']->count() > 1)
                  Varias tiendas
                @else
                  {!! @$cupon['tienda'][0]->direccion !!}
                @endif
              </p>
            </div>
            <div class="cui-price-promotions-container">
              <div class="cui-price" data-pingdom-id="deal-price">
                @if (isset($cupon['precio']))
                  <span class="original-price">{!! $cupon['precio'] !!}&nbsp;€</span>
                  <span class="cui-price-discount c-txt-price"><span class="cui-price-descriptor">Desde</span> {!! $cupon['precio_descuento'] !!}&nbsp;€</span>
                @else
                  <span class="cui-price-discount c-txt-price
                    "><span class="cui-price-descriptor">Tu descuento</span> {!! $cupon->filtro->nombre !!}
                @endif 
              </div>
            </div>
          </div>
        </figcaption>
      </a>
    </div>
  </figure>

@endforeach

@if ($data['cupon_inferior'])
  <div class="card-ui cui-c-deal cui-c-deal-featured v1">
    <div style="border-bottom: solid 1px#e6e7e8!important;"></div>
  </div>
  <figure class="card-ui cui-c-deal cui-c-deal-featured v1">
    <div class="cui-image-container">
      <a href="{!! route('home_ver_cupon',$data['cupon_inferior']->slug) !!}">
        <div class="cui-bg-image " style="background-image: url({!! asset('img/cupones') !!}/{!! $data['cupon_inferior']->imagen !!})" alt="{!! $data['cupon_inferior']->titulo !!}" title="{!! $data['cupon_superior']->titulo !!}">
          <p style="display:none">{!! $data['cupon_inferior']->descripcion_corta !!}</p>
        </div>
      </a>
    </div>
    <figcaption>

      <h3 class="cui-title">
        <a class="cui-url c-txt-black should-truncate" href="" style="word-wrap: break-word;">{!! $data['cupon_inferior']->titulo !!}</a>
      </h3>
      <div class="cui-description c-txt-gray-md">
        <p>{!! $data['cupon_inferior']->descripcion_corta !!}</p>
      </div>
      <div class="cui-location cui-truncate c-txt-gray-dk cui-has-distance">
        <span class="cui-location-name ">

          @if ($data['cupon_inferior']->count() > 1)
            Varias tiendas
          @else
            {!! @$data['cupon_inferior'][0]->direccion !!}
          @endif

        </span>
      </div>

      <div class="cui-price-promotions-container">
        <div class="cui-price" data-pingdom-id="deal-price">
          <span class="cui-price-discount c-txt-price">
            <span class="cui-price-descriptor">
              <span class="cui-price-descriptor">Tu descuento </span>
            </span>
            {!! $data['cupon_inferior']->filtro->nombre !!}
          </span>
        </div>
      </div>
      <div class="cui-view-deal">
      <a href="{!! route('home_ver_cupon',$data['cupon_inferior']->slug) !!}" class="btn" >
      Ver oferta
      </a>
      </div>
    </figcaption>
  </figure>
@endif
  

</div>


{{-- COMENTAMOS LA PAGINACION HASTA QUE QUEDA DEFINDA
@if (is_null($data['cupones']->links()))
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
@endif--}}

</div>
</div>
</section>
@endsection


@section('JSpage')


@endsection