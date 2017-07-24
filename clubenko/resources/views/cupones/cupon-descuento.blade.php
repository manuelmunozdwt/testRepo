@extends('layouts.app')

@section('CSSHeader')


@section('content')
<div class="container" id="content">

    <div class="row">
        <div class="col-xs-12">
        	<div class="atras">
                <a href="{!! URL::previous() !!}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    @if(isset($data))

    <div class="row descuentos">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div class="promo">
                <div class="brand">
                    <div class="logo-blanco">
                         {!! $data['program']['$'] !!}
                    </div>
                </div>
                <a href="{!! route('cupon-descuento', $data['@id']) !!}">
                    <img src="{!! asset('img/cupones/pizza.png') !!}">
                </a>
                <div class="datos-cupon">
                    <div class="datos-descuento">
                        <p class="cupon-titulo"><a href="">{!! $data['name'] !!}</a></p>
                        <p class="cupon-descripcion"></p>
                    </div>      
                </div>

            </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-xs-12  col-md-4 col-md-offset-4 section-title">
            <p>Detalles de la oferta</p>
        </div>

    	<div class="col-xs-12  col-md-4 col-md-offset-4 section-description">


            <p class="cupon-title">{!! $data['name'] !!}</p>
            <p>{!! $data['info4customer'] !!}</p>
    	</div>

    </div>
    <div class="row">
    	<div class="col-xs-12 col-md-12 section-title">
            <p>Condiciones</p>
        </div>
        <div class="col-xs-12 section-description">

            <p>Esta oferta caduca el {!! date_format(date_create($data['endDate']), 'd-m-Y') !!}</p>
   		</div>
    </div>    
    <div class="row">
      <div class="col-xs-12 col-md-12 section-title">
            <p>Detalles del cupón</p>
        </div>
        <div class="col-xs-12 section-description">
          <p>Código del descuento: {!! $data['couponCode'] !!}</p>
          @if ($data['admedia']['admediumItem']['trackingLinks'] != '')
            <a type="button" class="btn btn-comentario" href="$data['admedia']['admediumItem']['trackingLinks']" target="_blank">Ir a la tienda</a>

          @endif 
      </div>
    </div>
    @else
    <div class="row" id="caja-cupon">
     
        <div id="cupon" >
           
        </div>

    </div>
    <div id="td">
        <div class="row" >
            <div class="col-xs-12  col-md-4 col-md-offset-4 section-title">
                <p>Detalles de la oferta</p>
            </div>

            <div class="col-xs-12  col-md-4 col-md-offset-4 section-description">
                <p class="cupon-title"></p>
                <p class="cupon-description"></p>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 section-title">
                <p>Condiciones</p>
            </div>
            <div class="col-xs-12 section-description">

                <p>Esta oferta caduca el <span class="enddate"></span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 section-title">
                <p>Detalles del cupón</p>
            </div>
            <div class="col-xs-12 section-description">
                <p>Código del descuento: <span class="code"></span></p>
                <a type="button" class="btn btn-comentario" target="_blank">Ir a la tienda</a>

            </div>
        </div>

    </div>

    @endif

</div>


@include('cupones.include.modal-descuento')
@endsection


@section('JSpage')
<script type="text/javascript">
$(document).ready(function(){
    if({{isset($id_cupon)}}){

      var id = {{$id_cupon}};
      console.log(id);
      $("#caja-cupon").hide();
      $.ajax({
        type: "GET",
        url: "https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=1;id="+id+"?token=B73AE30C600218523B4DE65A97C01A8309535FD5",//test token
        //url: "https://api.tradedoubler.com/1.0/vouchers.json;languageID=es;voucherTypeId=2?token=6913146397DAB113DEE823AFB898429738E1A4AE", //request to Tradedoubler. This is our token.
        dataType: "json",
        success: function (data) {
          var fecha_fin = new Date(data[0].endDate*1);
          var hits = data.length;
          if (hits==0) {
              //no hits :(
              var div=document.createElement("div");
                div.className = "col-md-12";
                div.innerHTML = "No se han encontrado cupones :(";

              $("#cupon").append(div);
          } else {
     
              var div=document.createElement("div");
                div.className = "col-md-12";
                div.innerHTML =  "<div class=\"promo\">"
                                  +"<div class=\"brand\">"
                                    +"<div class=\"logo-tienda\">"
                                      +"<a><img src=\""+data[0].logoPath+"\" width=\"120px\"></a>"
                                    +"</div>"
                                  +"</div>"
                                  +"<a ><img src=\"http://localhost/ClubEnko/public/img/cenar.png\"></a>"
                                  +"<div class=\"datos-cupon\">"
                                    +"<div class=\"datos-descuento\">"
                                      +"<p class=\"cupon-titulo\">"+data[0].title+"</p>"
                                      +"<p class=\"cupon-descripcion\">"+data[0].id+"</p>"                                      
                                    +"</div>";     

            
              $("#cupon").append(div);
              $('#td .cupon-title').html(data[0].title);
              $('#td .cupon-description').html(data[0].shortDescription);
              $('#td .code').html(data[0].code);
              $('#td .enddate').html(fecha_fin.toLocaleDateString().replace(/\//g, '-'));
              $('#td .btn-comentario').attr('href', data[0].defaultTrackUri);
              //agregamos los datos a la modal
              $('.modal-header .logo').html("<img src=\""+data[0].logoPath+"\" width=\"120px\">");
              $('.modal-body .titulo-cupon').html(data[0].title);
              $('.modal-body .copiar-codigo').html(data[0].code);
              $('.modal-footer .btn-comentario').attr('href', data[0].defaultTrackUri);
          }
          $("#caja-cupon").show(); //show table when done

        }
      });
    }
    
    setTimeout(function(){
      $('#myModal').modal('show');
    }, 7000);


});

</script>


<script type="text/javascript">
var copiar_btn = document.querySelector('.boton-copiar');  
copiar_btn.addEventListener('click', function(event) {  
  // Select the email link anchor text  
  var texto_copiar = document.querySelector('.copiar-codigo');  
  var range = document.createRange();  
  range.selectNode(texto_copiar);  
  window.getSelection().addRange(range);  

  try {  
    // Now that we've selected the anchor text, execute the copy command  
    var successful = document.execCommand('copy');  
    var msg = successful ? 'successful' : 'unsuccessful';  
    //console.log('El texto copiado es ' + msg);  
  } catch(err) {  
    //console.log('Oops, no se pudo copiar');  
  }  

  // Remove the selections - NOTE: Should use
  // removeRange(range) when it is supported  
  window.getSelection().removeAllRanges();  
});
</script>
@endsection