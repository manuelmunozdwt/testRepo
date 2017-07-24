<html id="ls-html" class=" hashchange history pointerevents no-touchevents cssanimations flexbox flexboxlegacy no-flexboxtweener cssgradients supports csstransforms3d csstransitions formvalidation no-touch csspseudoanimations webp webp-alpha webp-animation webp-lossless" lang="es"><!--<![endif]-->

  <head>

    <title> @section('title') {!! Config::get('constantes.cliente') !!}  @show </title>
    <meta name="description" content="Ofertas desde el  50 al 90% de descuento en restaurantes, fitness, viajes, shopping, belleza, Spas y más.">
    <link rel="canonical" href="https://www.ClubEnko.com">
    <meta charset="utf-8">
    {!! Html::style('css/public/style.css') !!}
    {!! Html::style('font-awesome/css/font-awesome.min.css') !!}
    <link rel="apple-touch-icon" sizes="76x76" href="">
    <link rel="apple-touch-icon" sizes="152x152" href="">
    <link rel="icon" type="image/png" href="" sizes="96x96">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @section('CSSHeader')
    @show 

  </head>
  
  <body dir="ltr" id="ls-body" class="brand-clubenko s-web ltr es_ES es_XX">

    <div id="global-container">

      <div class="header-v2">
        <header data-bhw="Header" role="banner" class="header">
          <div class="ls-header-top">
            <div class="row ls-header-top-row" id="ls-header-top-row">
              <a href="{!! route('home') !!}" class="ls-clubenko-logo" aria-label="clubenko">
                <img src="{!! asset('img/'.Config::get('constantes.logo')) !!}" alt="Club privado ClubEnko" title="Club privado ClubEnko">
              </a>
            <div id="ls-header-main" class="ls-clearfix alternative-search">
                  <div id="ls-search-bar-wrapper" class="columns search-bar-wrapper">
            <form class="search-bar-v2 ls-two-fields" id="search-bar" data-bhw="SearchBar" role="search" action="" aria-label="¿Qué estás buscando?" data-bhw-path="Header|SearchBar">
              <label class="icon-magnifying-glass search-box deal-search search-bar-icon" for="search">
                <span id="placeholderSearch" class="ls-flex-placeholder">
                    ¿Qué estás buscando?
                </span>
                <input type="search" name="search" id="search" data-bhw="FreeTextSearchField" maxlength="50" autocomplete="off" spellcheck="false" aria-labelledby="placeholderSearch" aria-autocomplete="list" aria-haspopup="true" aria-owns="autocomplete-list" aria-busy="true" role="combobox" data-bhw-path="Header|SearchBar|FreeTextSearchField">
              </label>
              <label for="location" class="search-box location-search search-bar-icon icon-marker">
                <span id="placeholderLocation" class="ls-flex-placeholder isHidden">
                  Introduce tu localización
                  
                </span>
                <input type="text" name="location" id="location" data-bhw="LocationBarField" autocomplete="off" spellcheck="false" maxlength="50" aria-labelledby="placeholderLocation" aria-autocomplete="list" aria-haspopup="true" aria-owns="autocomplete-list" aria-busy="true" role="combobox" data-bhw-path="Header|SearchBar|LocationBarField">
              </label>
              <button id="ls-header-search-button" class="ls-header-search-button icon-magnifying-glass" type="submit" data-bhw="LocationBarFindDeals" data-bhw-path="Header|SearchBar|LocationBarFindDeals">
                <span class="accessibility-hidden">Buscar</span>
              </button>
              <div class="typeahead-response" id="ls-search-results" aria-hidden="true" aria-live="polite">
                <ul id="autocomplete-list" role="list" aria-busy="true"></ul>
              </div>
            </form>
          </div>
                <div class="columns user-wrapper">

                  
                  <div id="ls-user-nav">
                    <nav class="user-menu signed-out">
                      <a id="user-help" class="responsive-hide-500 user-menu-item user-help" href="" ">
                        Ayuda
                      </a>
                       @if (Auth::check())
                       <a class="first user-menu-item user-menu-action">
                          Bienvenido {!! Auth::user()->nombre_completo !!}
                        </a>
                        <a class="first user-menu-item user-menu-action" href="{{ route('mis_datos') }}">Mi cuenta</a>
                      @else
                        <a class="first user-menu-item user-menu-action" href="{!! route('login') !!}" >
                          Inicia sesión
                        </a>
                        <a class="last user-menu-item user-menu-action" href="{!! route('registro') !!}" >
                          Inscríbete
                        </a>
                      @endif
                      
                    </nav>
                  </div>

                </div>
              </div>
            </div>
          </div>
            <nav id="ls-channel-nav" class="ls-channel-nav" role="navigation">
      <div id="ls-primary-nav-row" class="row">
        <ul class="primary-nav" role="menubar">
              <li data-id="nav-principal" class="primary-nav-tab">
                <a id="sls-aria-1" tabindex="0">
                  Principal
                </a>
              </li><li class="p-nav-divider">|</li>
              <li data-id="nav-categorias" class="primary-nav-tab">
                <a id="sls-aria-2" tabindex="0">
                  Categorias
                </a>
              </li><li class="p-nav-divider">|</li>
              <li data-id="nav-tiendas" class="primary-nav-tab">
                <a id="sls-aria-3" tabindex="0">
                  Shopping
                </a>
              </li>
        </ul>
      </div>
      <div id="ls-rail" class="ls-rail row"><span id="ls-rail-slide" style="display: none;"></span></div>
  <nav class="subnav">
      <nav class="subnav-flyout home-tab-flyout row hide" id="nav-principal" data-bhw="SubNav-home-tab" role="menu" aria-hidden="true" aria-labelledby="sls-aria-1" style="display: none;">
        <div class="ls-flex-wrap">
                                <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-home-1" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy"  alt="" width="220" height="210">
                    </a>
                  </div>
                  <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-home-2" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy" alt=""  width="220" height="210">
                    </a>
                  </div>
                  <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-home-3" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy" alt="" width="220" height="210">
                    </a>
                  </div>
                  <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-home-4" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy" alt="" width="220" height="210">
                    </a>
                  </div>
                    </div>
        </nav>
      <nav class="subnav-flyout local-tab-flyout row hide" id="nav-categorias" role="menu" aria-hidden="true" aria-labelledby="sls-aria-2" style="display: none;">
        <div class="ls-flex-wrap">
          <div class="flyout-column subnav-categories">
            <a class="subnav-link subnav-link-count" id="all-deals" tabindex="-1" role="menuitem">
              Todas las ofertas
              <span class="count">{!! total_cupones_activos() !!}</span>
            </a>
            {!! menu_categorias(0,9) !!}
          </div>
          <div class="flyout-column subnav-categories">
            {!! menu_categorias(10,19) !!}
          </div>
          <div class="flyout-column subnav-megamind">
            <a id="ls-widget-local-1" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
            {!! menu_banner(1) !!}
            </a>
          </div>
          <div class="flyout-column subnav-megamind">
            <a id="ls-widget-local-2" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
              {!! menu_banner(2) !!}
            </a>
          </div>
        </div>
      </nav>
      <nav class="subnav-flyout goods-tab-flyout row hide" id="nav-tiendas" data-bhw="SubNav-goods-tab" role="menu" aria-hidden="true" aria-labelledby="sls-aria-3" style="display: none;">
        <div class="ls-flex-wrap">
                  <div class="flyout-column subnav-categories">
                      <a class="subnav-link subnav-link-count" href="" data-bhc="category:goods-tab-all-goods" id="all-goods" tabindex="-1" role="menuitem">
                        Todos los productos
                          <span class="count">3847</span>
                      </a>
                      
                </div>
                <div class="flyout-column subnav-categories">
                      <a class="subnav-link subnav-link-count" href="/goods/electronica-goods" data-bhc="category:goods-tab-electronica-goods" id="electronica-goods" tabindex="-1" role="menuitem">
                        Electrónica
                          <span class="count">537</span>
                      </a>
                </div>
                <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-goods-1" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy" data-original="" data-original-2x="" alt=""  width="220" height="210">
                    </a>
                  </div>
                  <div class="flyout-column subnav-megamind">
                    <a id="ls-widget-goods-2" class="subnav-megamind-widget" href="" tabindex="-1" role="menuitem">
                      <img class="ls-lazy" data-original="" data-original-2x="" alt=""  width="220" height="210">
                    </a>
                  </div>
                    </div>
        </nav>

  </nav>

</header>

</div>

    
</head>



@yield('content')


<footer class="ls-footer" id="ls-footer">
  <div class="row res-fo-wrapper">
    <div class="ls-col footer-payload">
    {{-- 
      <div id="ls-footer-sitemap" class="footer-sitemap">
        <div class="ls-footer-sitemap-col footer-links">
          <h6 class="footer-link-headline">Compañía</h6>
          <a href="">Sobre </a>
          <a href="">Empleo</a><a href="">Prensa</a>
        </div>
        <div class="ls-footer-sitemap-col footer-links">
          <h6 class="footer-link-headline">Trabaja con ClubEnko</h6>
          <a href="">Ofértate con ClubEnko</a>
          <a id="ls-footer-affiliates" href="" >Programa de afiliación</a>
        </div>
        <div class="ls-footer-sitemap-col footer-links">
          <h6 class="footer-link-headline">Más</h6>
          <a href="">Atención al cliente</a>
          <a href="">FAQ</a>
          <a href="">Condiciones generales</a>
          <a href="">Groupones</a>
        </div>
        <div class="ls-footer-sitemap-col footer-links">
          <h6 class="footer-link-headline">Síguenos</h6>
          <a target="_blank" rel="noopener" class="follow-us-link icon-twitter" href="">
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </a>
          <a target="_blank" rel="noopener" class="follow-us-link icon-facebook" href="">
            <i class="fa fa-facebook" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      --}}
       <div class="footer-gsm">
        <h6>Ofertas imbatibles</h6>
        <p>ClubEnko es una forma fácil de conseguir grandes descuentos
            mientras te diviertes con nuevas experiencias en tu ciudad.
            Encuentra ofertas diarias de 
            <a class="ch-txt-ntc" href="">restaurantes</a>,
            <a class="ch-txt-ntc" href="">spa</a>, 
            <a class="ch-txt-ntc" href="">cosas que hacer</a>, 
            <a class="ch-txt-ntc" href="">peluqueria</a>,
            <a class="ch-txt-ntc" href="">masajes</a> y 
            <a class="ch-txt-ntc" href="">hoteles</a>.</p>
      </div>        
      <div class="footer-copyright">
        © 2017 ClubEnko International Limited. Todos los derechos reservados.
        <span class="footer-copyright-links">
            <a id="ls-footer-terms_of_use" href=""">Términos y Condiciones</a>
            <a id="ls-footer-privacy_policy" href="">Privacidad</a>
            <a id="ls-footer-contact" href="">Contacto</a>
            <a id="ls-footer-cookie_policy" href="">Cookies</a>
        </span>
      </div>

    </div>

   {{-- <div class="ls-col footer-widgets">
      <a href="" class="footer-widget footer-widget-mobile" title="ClubEnko en tu smartphone">
        <span class="footer-widget-image">
          <i class="fa fa-mobile fa-5x" aria-hidden="true"></i>
        </span>
        <span class="footer-widget-headline">Descarga la app de ClubEnko <i class="fa fa-chevron-right" aria-hidden="true"></i></span>
      </a> 

      <a href="" class="footer-widget footer-widget-works" title="ClubEnko Funciona">
          <span class="footer-widget-image">
              <img class="svg-clubenko-merchant" alt="ClubEnko"> 
            </span>
        <span class="footer-widget-headline">Trae nuevos clientes y haz crecer tu negocio <i class="fa fa-chevron-right" aria-hidden="true"></i></span>

      </a>
    </div>--}}
  </div>
</footer>
<div class="touch-footer hide">
  <a class="row" href="">
    Ir a la app
  </a>
</div>
</div>
</div>
  <script src="https://unpkg.com/jquery@3.2.1"></script>
  <script src="{!! asset('js/script.js') !!}"></script>
  <script>

    {{-- Detectamos todos los clicks de la pantalla y obtenemos si ID o data en caso de ser necesario para un posterior procesamiento --}}
    function load() { 
      var el = document.getElementById("ls-body"); 
      console.log(el)
      el.addEventListener("click", get_attribute, false); 
    }

    function get_attribute()
    {
      if (event.target.id){
        console.log(event.target.id);
        console.log('data ' + $(event.target).data('id'));
        
      }
      else{
        console.log('no');
      }
      
    }

    document.addEventListener("DOMContentLoaded", load, false);

  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfG2Fej_lh3gaXBLiZqULBgw0-wlk54W0&callback=initMap" async defer></script>
  <script>
    function initMap()
    {}
  </script>
  <script type="text/javascript" src="{!! asset('js/ajaxSetup.js') !!}"></script>
  @section('JSpage')
  @show

</body>
</html>
