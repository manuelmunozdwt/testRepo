@extends('layouts.public-desktop')

@section('title') {!! Config::get('constantes.cliente') !!} @endsection

@section('CSSHeader')
  {!! Html::style('css/public/desktop-style.css') !!}
@endsection

@section('content')
<section id="ls-in-app-messages"><div class="row">
  <div id="in-app-messages" class="twelve column" data-bhw="SiteAnnouncement" data-bhw-path="SiteAnnouncement">
      <div id="message-72929" class="in-app-msg-banner">
        @if ($data['banner-cabecera'])
          <a href="{!! $data['banner-cabecera']->enlace !!}" target="_blank"><img src="{!! asset($data['banner-cabecera']->imagen) !!}" alt="{!! $data['banner-cabecera']->alt !!}" title="{!! $data['banner-cabecera']->alt !!}"></a>
        @endif
      
    </div>
  </div>
</div>
</section>

  <div class="ls-resp-main">
    <div class="homepage-content main module ">
      <div class="row top-row">
        <div class="three columns">
          <div id="left-nav-categories" >
            <div class="side-title">
              <img src="{!! asset('img/front/search.png') !!}" class="explore-icon" alt="explore-icon">
              <h2>Buscar</h2>
            </div>
            <ul>
              @foreach ($data['categorias'] as $categoria)
                <li>
                  <a href="">
                    <div class="category_item">
                      <a href="{!! route('home_ver_categoria', $categoria->slug) !!}">{!! $categoria->nombre !!}</a>
                      <span class="counter">({!! $categoria->cupones_activos->count() !!})</span>
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="nine columns">
          @if (isset($data['desktop_cupon_principal']))
            <div id="featured">
              <section class="mm-widget">
                <figure class="hero-deal" style="background-image:url('{!! $data['desktop_cupon_principal']->imagen_url !!}')" alt="{!! $data['desktop_cupon_principal']->descripcion_corta !!}" title="{!! $data['desktop_cupon_principal']->descripcion_corta !!}">

                  <a class="container-link" href="">
                  <span style="display: none">{!! $data['desktop_cupon_principal']->titulo !!}</span></a>
                  <figcaption>
                    <a href="{!! $data['desktop_cupon_principal']->url !!}">
                      <div class="deal-info">
                        <h2>
                          <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $data['desktop_cupon_principal']->titulo !!}</p>
                        </h2>
                        <div class="deal-metadata">
                            <div class="merchant-name ">{!! $data['desktop_cupon_principal']->descripcion_corta !!}</div>
                        </div>
                        <p class="deal-price">
                          @if ($data['desktop_cupon_principal']->filtro->id != 1)
                            <s class="original-price">{!! $data['desktop_cupon_principal']->filtro->nombre !!}€</s>
                          @endif
                          <span class="deal-from">Tu descuento</span> {!! $data['desktop_cupon_principal']->filtro->nombre !!}
                        </p>
                        <div class="view-deal">
                          <div class="btn-buy">Ver Oferta</div>
                        </div>
                      </div>
                    </a>
                  </figcaption>
                </figure>
              </section>
            </div>
          @endif

          <div style="margin-top:10px;">
            @if ($data['banner-home'])
              <a href="{!! $data['banner-home']->enlace !!}" target="_blank"><img src="{!! asset($data['banner-home']->imagen) !!}" alt="{!! $data['banner-home']->alt !!}" title="{!! $data['banner-home']->alt !!}"></a>
            @endif
          </div>
        </div>
      </div>

      <section class="four-pack deal-pack row pad-row mm-widget">
        <div class="section-head">
          <h2>Nuevas ofertas</h2>
        </div>
        <div class="block-grid four-up">
          
        @foreach ($data['cupones'] as $cupon)
           <figure class="deal-card">
            <a href="{!! $cupon->url !!}">
              <img class="" src="{!! $cupon->imagen_url !!}" alt="{!! $cupon['descripcion_corta'] !!}" title="{!! $cupon['descripcion_corta'] !!}" id="imagen-box-card">
              <figcaption>
                <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $cupon['titulo'] !!}</p>
                  <p class="merchant-name should-truncate" >
                    {!! $cupon['descripcion_corta'] !!}
                  </p>
                  <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    @if (count($cupon['tienda']) > 1)
                      Varias tiendas
                    @else
                      {!! @$cupon['tienda'][0]->direccion !!}
                    @endif
                  </p>

                  <div class="pricing">
                    <p class="deal-price very-long  ">
                      @if (isset($cupon['precio']))
                        <span class="original-price ">{!! $cupon['precio'] !!}&nbsp;€</span>
                        <span class="current-price"><span class="deal-from">Desde</span> {!! $cupon['precio_descuento'] !!}&nbsp;€</span>
                      @else
                        <span class="deal-from">Tu descuento</span> {!! $cupon['filtro']['nombre'] !!}
                      @endif  
                    </p>
                  </div>

              </figcaption>
            </a>
          </figure>
        @endforeach

  </div>
</section>

@if ($data['nuevos_cupones']->count() > 0)

  <section  class="four-pack deal-pack row pad-row mm-widget ">
  <div class="section-head">
      <h2>Nuevos cupones</h2>
  </div>

  <div class="block-grid four-up">

    @foreach ($data['nuevos_cupones'] as $nuevo_cupon)

      <figure class="deal-card">
        <a href="{!! $nuevo_cupon->url !!}">
            <img src="{!! $nuevo_cupon->imagen_url !!}"  alt="{!! $nuevo_cupon->descripcion_corta !!}" title="{!! $nuevo_cupon->descripcion_corta !!}">
        <figcaption>
            <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $nuevo_cupon->titulo !!}</p>
              <p class="merchant-name should-truncate">
                {!! $nuevo_cupon->descripcion_corta !!}
              </p>
              <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                @if (count($nuevo_cupon['tienda']) > 1)
                  Varias tiendas
                @else
                  {!! @$nuevo_cupon['tienda'][0]->direccion !!}
                @endif
              </p>
            <div class="pricing">
              <p class="deal-price very-long  ">
                @if (isset($nuevo_cupon['precio']))
                  <span class="original-price ">{!! $nuevo_cupon['precio'] !!}&nbsp;€</span>
                  <span class="current-price"><span class="deal-from">Desde</span> {!! $nuevo_cupon['precio_descuento'] !!}&nbsp;€</span>
                @else
                  <span class="deal-from">Tu descuento</span> {!! $cupon['filtro']['nombre'] !!}
                @endif  
              </p>
            </div>
          </figcaption>
        </a>
      </figure>

    @endforeach
      

  </div>
</section>
@endif

@if ($data['nuevas_promociones']->count() > 0)

 <section class="four-pack deal-pack row pad-row mm-widget ">
  <div class="section-head">
      <h2>Nuevas promociones</h2>
  </div>
  <div class="block-grid four-up">

    @foreach ($data['nuevas_promociones'] as $nueva_promocion)
      <figure class="deal-card">
        <a href="{!! $nueva_promocion->url !!}">
            <img src="{!! $nueva_promocion->imagen_url !!}"  alt="{!! $nueva_promocion->descripcion_corta !!}" title="{!! $nueva_promocion->descripcion_corta !!}">
              <figcaption>
                  <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $nueva_promocion->titulo !!}</p>
                    <p class="merchant-name should-truncate">
                      {!! $nueva_promocion->descripcion_corta !!}
                    </p>
                    <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                      <i class="fa fa-map-marker" aria-hidden="true"></i>
                      @if (count($nueva_promocion['tienda']) > 1)
                        Varias tiendas
                      @else
                        {!! @$nueva_promocion['tienda'][0]->direccion !!}
                      @endif
                    </p>
                  <div class="pricing">
                    <p class="deal-price very-long  ">
                      @if (isset($nueva_promocion['precio']))
                        <span class="original-price ">{!! $nueva_promocion['precio'] !!}&nbsp;€</span>
                        <span class="current-price"><span class="deal-from">Desde</span> {!! $nueva_promocion['precio_descuento'] !!}&nbsp;€</span>
                      @else
                        <span class="deal-from">Tu descuento</span> {!! $nueva_promocion['filtro']['nombre'] !!}
                      @endif  
                    </p>
                  </div>
            </figcaption>
          </a>
        </figure>
      @endforeach
        
    </div>
  </section>
@endif


@if ($data['mas_visualizados']->count() > 0)

  <section class="deal-pack row pad-row mm-widget three-pack">
    <div class="section-head">
        <h2>Más visualizados</h2>
    </div>
    <div class="block-grid three-up">

      @foreach ($data['mas_visualizados'] as $mas_visualizados)
        <figure class="deal-card">
           <a href="{!! $mas_visualizados->url !!}">
              <img src="{!! $mas_visualizados->imagen_url !!}"  alt="{!! $mas_visualizados->descripcion_corta !!}" title="{!! $mas_visualizados->descripcion_corta !!}">
          <figcaption>
              <p class="deal-title should-truncate" style="word-wrap: break-word;">{!! $mas_visualizados->titulo !!}</p>
                <p class="merchant-name should-truncate">
                  {!! $mas_visualizados->descripcion_corta !!}
                </p>
                <p class="deal-location" style="word-wrap: break-word;overflow: hidden;">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  @if (count($mas_visualizados['tienda']) > 1)
                    Varias tiendas
                  @else
                    {!! @$mas_visualizados['tienda'][0]->direccion !!}
                  @endif
                </p>
              <div class="pricing">
                <p class="deal-price very-long  ">
                  @if (isset($mas_visualizados['precio']))
                    <span class="original-price ">{!! $mas_visualizados['precio'] !!}&nbsp;€</span>
                    <span class="current-price"><span class="deal-from">Desde</span> {!! $mas_visualizados['precio_descuento'] !!}&nbsp;€</span>
                  @else
                    <span class="deal-from">Tu descuento</span> {!! $mas_visualizados['filtro']['nombre'] !!}
                  @endif  
                </p>
              </div>
            </figcaption>
          </a>
        </figure>
      @endforeach
        
    </div>
  </section>

@endif


    
    <section id="popular-categories" class="row pad-row mm-widget">
      <div class="section-head">
        <h2>Categorías populares</h2>
      </div>
      
      <ul class="block-grid five-up">

        @foreach ($data['categorias_populares'] as $categoria)
          <li>
            <a href="{!! route('home_ver_categoria', $categoria->slug) !!}">
              <img class="" alt="Gastronomía" src="{!! asset($categoria->imagen) !!}">
              <p class="title">{!! $categoria->nombre !!}</p>
              <p class="deal-count">{!! $categoria->cupones_activos->count() !!} {!! ($categoria->cupon->count()) == 1 ? 'Oferta' : 'Ofertas' !!}</p>
            </a>
          </li>
        @endforeach

      </ul>
    </section>
              
    <div id="browse-by-location" class="row pad-row">
        <h3>
          Buscar por ciudad
          <section class="row pad-row">
            <div class="twelve columns dotted-line"></div>
          </section>
        </h3>
        <ul class="block-grid six-up">

          @foreach ($data['provincias'] as $grupo)
            <li>
              <ul>

                @foreach ($grupo as $provincia)
                  <li><a href="{!! route('home_cupones_provincias',$provincia->slug) !!}">{!! $provincia->nombre !!}</a></li>
                @endforeach

              </ul>
            </li>

          @endforeach

        </ul>
      </div>
                
</div>


      </div>


@endsection


@section('JSpage')

@endsection