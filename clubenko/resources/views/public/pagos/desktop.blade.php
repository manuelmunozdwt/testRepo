@extends('layouts.public-desktop')

@section('title') {!! Config::get('constantes.cliente') !!} @endsection

@section('CSSHeader')

{!! Html::style('css/public/desktop-style.css') !!}

{!! Html::style('css/public/pagos.css') !!}
<style type="text/css">
  #msg-error {
    color:red;
} 
</style>
@endsection

@section('content')
<section class="main">
  <div class="row">
    <div class="ls-resp-main">

  <div class="row head">

    <div id="mod-welcome" data-bhw="ModWelcome" data-bhw-path="ConfirmationForm|ModWelcome">
        <h1>¿Toda tu información aparece correctamente?</h1>
        <h2>Por favor, comprueba tu dirección de facturación y el contenido del pedido antes de finalizar tu compra</h2>
    </div>

  </div>
  <div class="row main">
    <div id="mod-messaging" class="module full" data-bhw="ModMessaging" data-bhw-path="ConfirmationForm|ModMessaging">
      
  </div>

    <div id="main" class="left columns twelve" style="min-height: 585px;">
      <span id="secure-transaction" class="secure show-medium-extra-large">
        <i class="fa fa-lock" aria-hidden="true"></i>
        Transacción Segura
      </span>

        <div id="account-billing-info" class="module main columns eight end international ">
          <h1>
            Método de pago

            <span id='msg-error'></span>

          </h1>
  <div class="credit-card-list" data-bhw="CreditCards" data-bhw-path="ConfirmationForm|CreditCards">
  
    <div class="section row list payment-method payment-methods-container ">
      <div class="payment-creditcard payment-row " data-bhw="creditcard-ES" data-bhw-path="ConfirmationForm|CreditCards|creditcard-ES">
  
          <div class="row">
            <input id="creditcard" type="radio" name="metodo_de_pago" value="creditcard" class="radio_metodo_de_pago">
            <label for="creditcard" class="label">
              <span class="payment-name">Introduce una tarjeta de crédito</span>
              <span class="payment-icon creditcard"></span>
            </label>
          </div>
{!! Form::open(['route'=>'promocion_realizar_pago','id'=>'formularioTarjeta']) !!}
{!! Form::hidden('amount',$data->precio_descuento) !!}
{!! Form::hidden('slug',$data->slug) !!}

          <div class="twelve columns row panel new-payment hidden"  style="display: block;">
            <div class="form row card-wrapper">
              @if (count($errors) > 0)
                  <div class="twelve columns alert alert-success">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

            
              <div class="six columns left payment-form-left">

                <div class="field ">
                  <label id="lbl-bldr-creditcard-0">Número de Tarjeta de Crédito</label>
                  <input type="text" id='card-number'  class="billing_record_number" name="number">
                </div>

                <div class="field ">
                  <label id="lbl-bldr-creditcard-1">Fecha de caducidad</label>
                  <input type="text" autocomplete="off" class="billing_record_expiration" name="expiry">    
                </div>

              </div>

              <div class="six columns right payment-form-right">
                <div class="field w-help-field">
                  <label id="lbl-bldr-creditcard-2">Código de Seguridad</label>
                  <input type="text" id='card-cvc' class="billing_record_cvv" name="cvc" >
                </div>
              </div>

            </div>
          </div>
{!! Form::close() !!}
      </div>


      <div class="payment-paypal payment-row">
          <div class="row">
            <input id="paypal" type="radio" name="metodo_de_pago" value="paypal" class="radio_metodo_de_pago">
            <label for="paypal" class="label">
              <span class="payment-name"></span>
              <span id="formPagoPaypal">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formularioPaypal" id="formularioPaypal">
                  <input type='hidden' name='cmd' value='_xclick' />
                  {{--   <input type='hidden' name='business' value='info_1318871711_per@antyca.es' /> --}}
                  <input type='hidden' name='business' value='info@enkoteams.com' />
                  <?php $codigopedido = date("ymdHis"); ?>
                  <input type='hidden' name='item_number' value='{{ $codigopedido }}' />
                  <input type='hidden' id="amount" name='amount' value='{!! $data->precio_descuento !!}' />
                  <input type='hidden' name='invoice' value='{{ $codigopedido }}' />
                  <input type='hidden' name='currency_code' value='EUR' />
                  <input type='hidden' name='add' value='1' />
                  <input type='hidden' name='rm' value='2' />
                  <input type='hidden' name='no_note' value='1' />
                  <input type='hidden' name='upload' value='1' />
                  <input type='hidden' name='notify_url' value='' />
                  <input type='hidden' name='return' value='{{ route('pago_promocion_confirmado',$data->slug) }}' />
                  <input type='hidden' name='cancel_return' value='{{ route('pago_promocion_denegado') }}' />
                  <input type='image' src='https://www.paypal.com/es_ES/ES/i/btn/btn_xpressCheckout.gif' id="enlaceFormularioImagen"/>
                  <!--<input type='submit' value="Pagar con PayPal"/> -->
                </form>
              </span>
            </label>
          </div>

      </div>
  </div>

  </div>
</div>
          
          <div id="mod-items" class="module main columns eight end set-item-section-margin" data-bhw="OrderSubtotal" data-bhw-path="ConfirmationForm|OrderSubtotal">
                <h1 class="show-medium-extra-large">Tus pedidos</h1>
          
                  <div id="item-940e1570-b269-464b-8be9-e5a3d2480836" class="item section ">
          <div class="row">
            <div class="image-container columns three small-grid-one">
              <img class=""  src="{!! asset('img/cupones/'.$data->imagen) !!}"  alt="{!! $data->descripcion_corta !!}" width="150" height="101">
            </div>
            <div class="info-container columns nine small-grid-three">
              <div class="row">
                <h3 class="eight columns">{!! $data->descripcion_corta !!}</h3>
                <div class="columns four small-grid-one ">
                  <div class="subtotal row pull-right ltr ">
                    <span class="subtotal-formatted-amount">{!! $data->precio_descuento!!} €</span>
        
                  </div>

                </div>
              </div>
              <input type="hidden" name="items[0][deal_id]" value="yelmo-cines-13">
              <input type="hidden" name="items[0][option_id]" value="60344145">
                  <div class="quantity row">

          </div>
          
              </div>
          </div>
            </div>

          
          </div>


              <div id="mod-overview" class="module columns four pull-right sidebar" data-bhw="ModOverview" style="top: 0px;" data-bhw-path="ConfirmationForm|ModOverview">
                <h1>Total del pedido</h1>
              
                <div class="section first">

                  <div class="details">
                    <div id="overview-subtotal">
          <div class="item row">
      <span class="seven columns small-grid-three">Subtotal</span>
      <span class="five columns small-grid-one ltr subtotal-amount">{!! $data->precio_descuento!!} €</span>
    </div>
  

  </div>

      <div id="incentives">
        <div class="form promo-code hidden">

      <hr>
      <div id="overview-total">
        <div class="item row big">
    <span class="seven columns small-grid-three">Total del pedido</span>
    <span class="five columns small-grid-one ltr final-amount">{!! $data->precio_descuento!!} €</span>
  </div>
  
  </div>

      <div id="bucks-remaining">
        </div>

              
                  </div>

                  
                  <div class="floating-buy-button-container">
      <div class="floating-buy-button">
          
          <button class="btn complete-order" id="realizar_pago"><span class="responsive-label show-small-medium">Realizar pedido</span>
</button>
    
    
          <div id="legal-disclaimers" class="legal-disclaimers">
      
          <p id="accept-terms-and-conditions-disclaimer" class="legal-disclaimer">
      <label>Al hacer click "Realizar pedido", acepto los términos de EnkoTeam <a href="/terms_and_conditions/tou112015" target="_blank">Términos de Uso</a>, <a href="/privacy/privacy_grint112015" target="_blank">Política de Privacidad</a> y los  términos de  EnkoTeam <a href="/privacy/privacy_local112015" target="_blank">Política de Privacidad</a> con sus <a href="/terms_and_conditions/tc_local112015" target="_blank">Términos de Venta</a>.</label>
    </p>
    
        <div class="checkboxes"><div class="checkbox">
  <input type="checkbox" id="consent-required" name="isStorableForFutureUse" checked="">
  <label for="consent-required">Por favor guarda mi información de la tarjeta de crédito de forma segura para que no la tenga que añadir de nuevo en mi próxima compra en Groupon.</label>
</div>

          <div class="checkbox">
            <input type="checkbox" id="chk-acceptNewsletterOptin" name="acceptNewsletterOptin" checked="checked" data-parsley-multiple="acceptNewsletterOptin" data-parsley-id="23">
            <label for="chk-acceptNewsletterOptin">Deseo recibir correos electrónicos personalizados de Groupon International Limited acerca de los servicios, productos y viajes locales. Entiendo que puedo cancelar mi suscripción en cualquier momento.</label>
          </div>
        </div>
      </div>

        </div>
    </div>

                </div>

              
              </div>
    </div>

  </div>
  <footer class="row">

  </footer>

        <a href="/local/grouber.html" class="t-hide hide" aria-hidden="true">
  Grouber
</a>

      </div>
  </div>
</section>
@endsection

@section('JSpage')
<script type="text/javascript" src="{!! asset('js/card/jquery.card.js') !!}"></script>

<script type="text/javascript">
  $('#formularioTarjeta').card({
      // a selector or DOM element for the container
      // where you want the card to appear
      container: '.card-wrapper', // *required*

      // all of the other options from above
  });
  //ocultamos el visor de la tarjeta
  $('.jp-card-container').css({'display':'none'});
</script>

<script>
  $(document).ready(function(){


    $('#realizar_pago').click(function(){
      var metodo_pago = $('input:radio[name=metodo_de_pago]:checked').val();

      if (metodo_pago == 'creditcard') {
        $( "#formularioTarjeta" ).submit();
      }
      else if(metodo_pago == 'paypal')
      {
        $( "#formularioPaypal" ).submit();
      }else{

        $('#msg-error').html(" : Elija una de las dos opciones de pago")
  
      }
    });
  });
</script>
@endsection