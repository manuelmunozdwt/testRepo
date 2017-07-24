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
  #map {
    height: 300px;
  }
</style>
@endsection

@section('content')

<section class="main">
  <div class="row">
    <section class="module deal">
      <div class="module-body">
        <hgroup>
          <h1 id="deal-title" class="deal-page-title" itemprop="name">
            {!! $data['cupon']->descripcion_corta !!}
          </h1>
        
          <div class="subtitle-modules row ">
            <div class="columns">
              <div class="deal-recs">
                <div class="deal-page-recommendation-wrapper">  
                  <h3 class="ugc-star-ratings" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                    <meta itemprop="ratingCount" content="240">
                    <meta itemprop="ratingValue" content="90">
                    <meta itemprop="bestRating" content="100">
                    <div class="product-reviews-rating stars_cupon"></div>
                    <span class="star-rating-text"> {!! $data['comentarios']->count() !!} revisiones</span>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </hgroup>
        <div class="row deal-container">
          <div id="purchase-cluster" class="four columns push-eight ">
            <div class="purchase-cluster-container" style="position: relative; top: 0px; transform: translate3d(0px, 0px, 0px); overflow: hidden;">
              <div itemprop="offers" itemscope="" itemtype="http://schema.org/AggregateOffer">
                <meta itemprop="lowprice" content="54.9">
              </div>
      
          
          
      <div class="buy very-long">
        <ul class="t-pod multi-option-breakout">
          <li>
            <div class="option">
              <label for="breakout-option-41203549" enabled="">
                <div class="option-details c-txt-gray-dk">
                    <h3>{!! $data['cupon']->descripcion_corta !!}</h3>
                  <div class="breakout-pricing-messages with-discount-messaging">
                    <div class="breakout-messages">
                      <div class="sold-message details">
                        Más de {!! $data['cupon']->descargas !!} comprados
                      </div>
                    </div>

                    <div class="breakout-pricing">
                      @if (isset($data['cupon']->precio))
                        <div class="pricing-options-wrapper">
                            <div class="breakout-option-value">
                              {!! $data['cupon']->precio !!}&nbsp;€
                            </div>
                            <div class="breakout-option-price c-txt-price">
                             {!! $data['cupon']->precio_descuento !!}&nbsp;€
                            </div>
                        </div>
                      @endif
                        <div class="discount-message-wrapper">
                          <div class="discount-message c-txt-prim c-bdr-prim">
                            Tu Descuento {!! $data['cupon']->filtro->nombre !!}
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>
          </li>
        </ul>

          @if (isset($data['cupon']->precio))
            <a href="{!! route('pago_promocion', $data['cupon']->slug) !!}"  class="btn-buy-big buy-button state-buy " id="buy-link" >
                Comprar
            </a>
          @else

            <a href="{!! url('cupon-pdf', $data['cupon']->slug) !!}" class="btn-buy-big buy-button state-buy " id="buy-link" >
                Descargar
            </a>

          @endif
        <div class="order-processing-loader">
          <span class="icon-g-loader"></span>
        </div>
    
      </div>
          {{--  <div class="gift-wishlist">
            <div class="gift-wishlist-buttons">
              <div class="buy-for-friend-module">
                <a class="buy-for-friend gift-button btn-secondary">
                  <i class="fa fa-gift c-txt-brnd" aria-hidden="true"></i> 
                    Regálalo
                  </a>
              </div>
            </div>
          </div>--}}
                  
                
                
      
<div class="t-pod row deal-highlights c-txt-gray-dk">

  <div class="four  columns">
    <div class="icon-container">
      <div class="icon">
        <span class="icon-now">
          <i class="fa fa-clock-o" aria-hidden="true"></i>
        </span>
      </div>
    </div>
    <div class="text">

      @if ($data['cupon']->fecha_fin != '9999-12-31')
        Diponible hasta : 
        <p>{!! fecha_formato_europeo($data['cupon']->fecha_fin) !!}</p>

      @else
        Ilimitado!
      @endif

    </div>
  </div>

  <div class="three columns">
    <div class="icon-container">
      <div class="icon">
        <span class="">
            <svg class="icon-eye" width="26px" height="20px">
              <g transform="translate(-491.000000, -765.000000)">
               <path d="M503.203808,783.093128 C498.563793,782.873496 494.621168,780.176774 492.564097,776.325851 C494.976089,772.687201 499.155895,770.374836 503.795909,770.595034 C508.437056,770.814666 512.379115,773.511388 514.436186,777.361745 C512.024194,781.000961 507.844954,783.31276 503.203808,783.093128 M515.81568,776.624732 C514.146362,773.500633 511.493227,771.17921 508.337429,769.966138 C507.610038,769.686504 506.854345,769.46857 506.078839,769.310638 L503.156825,765.344804 C502.878322,764.967807 502.347355,764.887426 501.969225,765.165928 C501.592228,765.443865 501.511281,765.975964 501.79035,766.353528 L503.764776,769.031003 C502.621329,768.985152 501.497695,769.076288 500.409157,769.290826 C500.407459,769.288562 500.406327,769.285731 500.404629,769.283467 L498.292083,766.418625 C498.013581,766.041061 497.482048,765.960114 497.104484,766.239183 C496.727487,766.517686 496.647106,767.049218 496.925608,767.426782 L498.64474,769.757827 C497.641677,770.094069 496.681635,770.540126 495.779898,771.091471 L494.099824,768.813069 C493.821322,768.436072 493.290355,768.355691 492.912225,768.634193 C492.535228,768.91213 492.454281,769.444229 492.733349,769.821793 L494.383988,772.060004 C493.192426,773.000234 492.135587,774.141416 491.260455,775.462039 C490.942894,775.940928 490.913458,776.555672 491.184602,777.062864 C493.596029,781.577213 498.061696,784.41545 503.129654,784.655461 C508.198177,784.895471 512.912346,782.49197 515.739262,778.226123 C516.057389,777.746668 516.086258,777.131924 515.81568,776.624732 M503.684791,772.938306 C501.528659,772.836415 499.696315,774.502903 499.594423,776.659035 C499.491966,778.816299 501.157888,780.647512 503.314586,780.749403 C505.472416,780.85186 507.303063,779.185938 507.40552,777.02924 C507.507977,774.872542 505.842055,773.040198 503.684791,772.938306"></path>
              </g>
            </svg>    
        </span>
      </div>
    </div>
    <div class="text">
      {!! $data['cupon']->visitas !!}+ visitas por dia
    </div>
  </div>
      
{{-- STARS --}}

@if (auth()->check())
  {{-- La valoracion solo es para usuarios autentificados --}}

  <div class="five  columns">
      <div class="icon-container">
        <div class="icon">
          <div class="rating  {!!  ($data['valoracion_usario'])?'stars_cupon':'' !!}" data-cupon-id="{!! $data['cupon']->id !!}" disabled = 'disabled'>
            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="star" data-star="5"></label>
            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" class="star" data-star="4"></label>
            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="star" data-star="3"></label>
            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="star" data-star="2"></label>
            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="star" data-star="1"></label>
          </div>
        </div>
      </div>
      <div class="text" "="">
        {!! $data['comentarios']->count() !!} revisiones
      </div>
  </div>
@endif
</div>

        <span class="share-message">COMPARTE ESTA OFERTA</span>
        <div>
          <span>
            <a href="mailto:?subject={!! $data['cupon']->titulo !!}">
              <img src='{!! asset('img/redes-sociales/email.png') !!}' alt="" width="30px">
            </a>
          </span>
          <span>
            <a  href="javascript: void(0)"; onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={!! $data["cupon"]->url !!}','ventanacompartir', toolbar=0, status=0, width=650, height=450,left=400, top=200)">
              <img src='{!! asset('img/redes-sociales/facebook.png') !!}' alt="" width="30px">
            </a>
          </span>
          <span>
            <a  href="javascript: void(0)"; onclick="window.open('https://plus.google.com/share?url={!! $data["cupon"]->url !!}','ventanacompartir', 'toolbar=0, status=0, width=650, height=450,left=400, top=200');">
              <img src='{!! asset('img/redes-sociales/google+.png') !!}' alt="" width="30px">
            </a>
          </span>
          <span>
            <a  href="javascript: void(0)"; onclick="window.open('https://www.linkedin.com/cws/share?url={!! $data["cupon"]->url !!}','ventanacompartir', 'toolbar=0, status=0, width=650, height=450,left=400, top=200');">
              <img src='{!! asset('img/redes-sociales/linkedin.png') !!}' alt="" width="30px">
            </a>
          </span>
          <span>
            <a  href="javascript: void(0)"; onclick="window.open('http://twitter.com/home?status={!! $data["cupon"]->url !!}','ventanacompartir', 'toolbar=0, status=0, width=650, height=450,left=400, top=200');">
              <img src='{!! asset('img/redes-sociales/twitter.png') !!}' alt="" width="30px">
            </a>
          </span>
        </div>
  
      </div>
          </div>
          <div id="deal-info" class="eight columns pull-four">
            <figure class="featured-image-container">
              <div class="gallery-single">
                <div class="gallery-featured" style="height: 412px;">
                  <img class="featured-image init-no-animation" src="{!! asset('img/cupones/'.$data['cupon']->imagen) !!}"  alt="{!! $data['cupon']->descripcion_corta !!}">
                </div>
              </div>
            </figure>
            <section class="write-up module">
              <div class="module-body">
                <div class="row hide-diy-gift-card-msg pitch-container">
                  <article class="twelve columns pitch">
                    <div itemprop="description">
                      <h4>En resumen</h4>
                      <hr>
                      <section>
                        {!! $data['cupon']->descripcion !!}
                      </section>

                    </div>

                    <div class="t-pod fine-print ">
                       <h4>Condiciones</h4>
                       <hr>
                       <div>
                         <p>
                           
                           
                           {!!$data['cupon']->condiciones!!}
                           
                           
                           <span class="merchant-responsibility"> </span>
                         </p>
                       </div>
                     </div>
 
                     <div class="merchant-profile">
 
                       <h4>
                       Sobre {!! $data['cupon']->user->first()->nombre_comercio !!}
                       </h4>
                       <hr>
                       <p></p><p>{!! $data['cupon']->user->first()->sobre_comercio !!}</p><p></p>
                       <aside class="merchant-rail">
                         <h5>{!! $data['cupon']->user->first()->nombre_comercio !!}</h5>
                         <div class="merchant-links">
                           <ul>
                             <li>
                               <a href="{!! $data['cupon']->user->first()->web_comercio !!}" target="_blank" class="merchant-website">Web de la empresa</a>
                             </li>
                           </ul>
                         </div>
                         
                       </aside>
                      </div>
               
                    <div id="tips">
                      <h4>Opiniones de usuarios</h4>
                      <div class="deal-recs">
                        <div class="deal-page-recommendation-wrapper">  <h3 class="ugc-star-ratings">
                          <div class="product-reviews-rating stars_cupon"></div>
                            <span class="star-rating-text">{!! $data['comentarios']->count() !!}  revisiones</span>
                          </h3>
                        </div>
                      </div>
                      <div class="tip-widget-tips ">

                        @foreach ($data['comentarios'] as $comentario)
                          <div class="tip-item classic-tip">
                            <div class="tip-body five-star">
                              <div class="tip-text ugc-ellipsisable-tip ellipsis">
                                {!! $comentario->comentario !!}
                              </div>
                              <div class="user-text">
                                <span class="tips-reviewer-name">{!! $comentario->usuario->NombreCompleto !!}</span> ·
                                <span class="tips-reviewed-date">{!! $comentario->fecha_bonita !!}</span>
                                
                              </div>
                              <div class="tip-endorsement">
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                    
                    <div class="t-pod fine-print ">
                      <h4>Tienda Promocionadas</h4>
                      <hr>
                    </div>

                    @if ($data['tiendas']->count() > 1)
                      <div class="merchant-locations wide row">
                      @foreach ($data['tiendas'] as $tienda)
                         <div class="col-md-12"></div>
                          <div class="address">
                            <span class="icon-marker-filled c-txt-brnd">
                              <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                            <p>
                              <strong>{!! $tienda->nombre !!}</strong>
                              <br>
                            </p>
                            
                            
                            <p>{!! $tienda->direccion !!}</p>
                            <p>{!! $tienda->telefono !!}</p>
                      
                            </div>
                          
                      @endforeach 
                      </div>
                    @else
                    <div class="merchant-locations wide row">
                      <div class="g-map eight columns" id="merchant-info-map">
                        <div class="static-map">
                          <div id="map"></div>
                          
                        </div>
                        <div class="dynamic-map"></div>
                      </div>

                      <ol id="redemption-locations" class="four columns">
                        <li class="merchant-location">
                          <div class="address">
                            <span class="icon-marker-filled c-txt-brnd">
                              <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                            <p>
                              <strong>{!! $data['tiendas'][0]->nombre!!}</strong>
                              <br>
                            </p>
                            
                            
                            <p>{!! $data['tiendas'][0]->direccion !!}</p>
                            <p>{!! $data['tiendas'][0]->telefono !!}</p>

                          </div>
                        </li>
                      </ol>
                    </div>
                    
                    @endif
                    
                    
                  </article>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
  
  <section class="fake-wls-widget cui-four-up" >
    <div class="section-head">
        <h2>Nuevas ofertas</h2>
    </div>
    <div class="widget-deals row">

      @foreach ($data['otras_ofertas'] as $otra_oferta)
        <figure class="card-ui cui-c-udc c-bdr-gray-clr cui-udc-display-stacked-row">
        <a href="{!! $otra_oferta->url !!}">
          <div class="cui-content c-bdr-gray-clr ch-bdr-gray-md">
            <div class="cui-udc-image-container">
              <div class="cui-udc-image-overlay"></div>
              <div class="cui-image-lazy-container">
                <img class="cui-svg-placeholder c-bg-gray-bg" type="image/svg+xml" height="279" width="460" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' height='279' width='460'%2F%3E" alt="image placeholder">
                <img class="cui-image" src="{!! $otra_oferta->imagen_url !!}" title="{!! $otra_oferta->descripcion_corta !!}" alt="{!! $otra_oferta->descripcion_corta !!}">
              </div>
            </div>
            
            <div class="cui-udc-details c-txt-gray-dk">
              <div class="cui-udc-title c-txt-black ">
                {!! $otra_oferta->titulo !!}
              </div>
              
              
              <div class="cui-udc-stacked-rows">
                <div class="cui-udc-no-data"></div>
                
                <div class="cui-location cui-truncate c-txt-gray-dk ">
                  <span class="cui-location-name ">
                    @if ($otra_oferta->tienda->count() > 1)
                      Varias localizaciones
                    @else
                      {!! ($otra_oferta->tienda[0]->provincia)?$otra_oferta->tienda[0]->provincia->nombre : 'Sin tienda' !!}
                    @endif
                  </span>
                  
                </div>
                
                <div class="cui-quantity-bought c-txt-gray-dk">
                  {!! $otra_oferta->descargas !!} comprados
                </div>
                
                <div class="cui-price">
                  @if (isset($otra_oferta['precio']))
                    <span class="original-price">{!! $otra_oferta['precio'] !!}&nbsp;€</span>
                    <span class="cui-price-discount c-txt-price"><span class="cui-price-descriptor">Desde</span> {!! $otra_oferta['precio_descuento'] !!}&nbsp;€</span>
                  @else
                    <span class="cui-price-discount c-txt-price
                      "><span class="cui-price-descriptor">Tu descuento</span> {!! $otra_oferta->filtro->nombre !!}
                  @endif
                  </div>
                </div>
              </div>
            </div>
          </a>
        </figure>
      @endforeach

    </div>

          </section>
          <section class="fake-wls-widget cui-four-up">
            <div class="section-head">
                <h2>Otras recomendaciones</h2>
            </div>
            <div class="widget-deals row">
            @foreach ($data['cupones_recomendados'] as $cupon)
            
              <figure class="card-ui cui-c-udc c-bdr-gray-clr cui-udc-display-stacked-row" >
                <a href="{!! $cupon->url !!}">
                  <div class="cui-content c-bdr-gray-clr ch-bdr-gray-md">
                    <div class="cui-udc-image-container">
                      <div class="cui-image-lazy-container">
                        <img class="cui-svg-placeholder c-bg-gray-bg" type="image/svg+xml" height="279" width="460" src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' height='279' width='460'%2F%3E" alt="image placeholder">
                        <img class="cui-image" src="{!! asset('img/cupones/'.$cupon->imagen) !!}"  title="alt="{!! $cupon->descripcion_corta !!}"" alt="{!! $cupon->descripcion_corta !!}">
                      </div>
                    </div>
                    
                    <div class="cui-udc-details c-txt-gray-dk">
                      <div class="cui-udc-title c-txt-black " style = "height: 30px">
                        {!! $cupon->titulo !!}
                      </div>
                      
                      <div class="cui-udc-stacked-rows">
                        <div class="cui-udc-no-data"></div>
                        
                        <div class="cui-location cui-truncate c-txt-gray-dk ">
                          <span class="cui-location-name ">
                            @if ($cupon->tienda->count() > 1)
                              Varias localizaciones
                            @else
                              {!! ($cupon->tienda[0]->provincia)?$cupon->tienda[0]->provincia->nombre : 'Sin tienda' !!}
                            @endif
                          </span>
                          
                        </div>

                        <div class="cui-quantity-bought c-txt-gray-dk">
                          {!! $cupon->descargas !!} comprados
                        </div>

                        <div class="cui-price">

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
                  </a>
                </figure>
                @endforeach
                    </div>
                  </section>
                </div>
              </section>
@endsection

@section('JSpage')
  

  <script type="text/javascript">
    //recogemos la valoracion del cupon
    var valor_cupon = "{!! $data['cupon']->valoracion !!}";

    //definimos la ruta para la llamada post
    var ruta = "{!! route('valorar-cupon') !!}";
    </script>
  
  {{-- Si es una promoción y tiene precio cambiamos la ruta de la valoración --}}
    @if(isset($data['cupon']->precio))

      <script>
        ruta = "{!! route('valorar-promocion') !!}";        
      </script>

    @endif

    <script>

    //lanzamos la funcion que dibuja la valoracion del cupon
    dibujar_valoracion(valor_cupon);

    $('.star').on('click',function(){
      //guardamos la valoracion de un usario, al hacer click sobre la valoracion de estrellas
      
      //definimos los datos para la llamada post
      var data = {
        value : $(this).data('star'),
        cupon_id : $(this).parent().data('cupon-id'),
      }

      //realizamos y recogemos la respuesta de la llamada post
      $.post(ruta,data,function(response){
        //bloqueamos la votacion
        $('.rating').addClass('stars_cupon');
        //dibujamos la nueva valoracion del cupon
        dibujar_valoracion(response.valor_cupon);

      })
 
    })

    /**
     * [dibujar_valoracion dibuja con estrellas la valoracion de un cupon]
     * @param  {[type]} valor_cupon [description]
     * @return {[type]}             [description]
     */
    function dibujar_valoracion(valor_cupon){
      var stars_cupon = "";
      //un cupon tienes 5 estrellas como valoracion, recoremos un contador y segun el tipo de valoracion dibujamos un tipo de estrela u otro
      for (i = 1; i < 6 ; i++){

        if(i <= valor_cupon){
          //si el contador es menor o igual que el valor del cupon añadimos una estrella rellena
          stars_cupon += '<span><i class="fa fa-star" aria-hidden="true"></i></span>';
        }else{
          //para el resto del recorido del contador, añdimos estellas vacias
          stars_cupon += '<span><i class="fa fa-star-o" aria-hidden="true"></i></span>';
        }
      }

      $('.stars_cupon').html(stars_cupon)

    }
  </script>

  <script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: {!! $data['tienda_mapa_centrado']->latitud !!}, lng: {!! $data['tienda_mapa_centrado']->longitud !!}},
            zoom: 16
        });
        var marker = new google.maps.Marker({map: map,position: {lat: {!! $data['tienda_mapa_centrado']->latitud !!}, lng: {!! $data['tienda_mapa_centrado']->longitud !!} }});
    }
  </script>

@endsection