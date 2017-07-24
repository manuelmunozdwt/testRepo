<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
@if(isset($data))
  <div class="modal-dialog" role="document">
    <div class="modal-descuento">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div class=" modal-title" id="myModalLabel">
            <div class="logo-negro">
               {!! $data['program']['$'] !!}
            </div>
          </div>
      </div>
      <div class="modal-body">
        <p class="titulo-cupon">{!! $data['name'] !!}</p>
        <div class="codigo">
         <a class="copiar-codigo" >{!! $data['couponCode'] !!}</a>
         <span class="copiar"><a class="boton-copiar">Copia</a></span>
        </div>
        <p class="text">Copia el código para realizar tu compra</p>
      </div>
      @if ($data['admedia']['admediumItem']['trackingLinks'] != '') 
      <div class="modal-footer">
        <a type="button" class="btn btn-comentario" href="$data['admedia']['admediumItem']['trackingLinks']" target="_blank">Ir a la tienda</a>
      </div>
      @endif

    </div>
  </div>

@else
  <div class="modal-dialog" role="document">
    <div class="modal-descuento">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div class=" modal-title" id="myModalLabel">
            <div class="logo">
               
            </div>
          </div>
      </div>
      <div class="modal-body">
        <p class="titulo-cupon"></p>
        <div class="codigo">
         <a class="copiar-codigo" ></a>
         <span class="copiar"><a class="boton-copiar">Copia</a></span>

        </div>
        <p class="text">Copia el código para realizar tu compra</p>
      </div>
      
      <div class="modal-footer">
        <a type="button" class="btn btn-comentario" target="_blank">Ir a la tienda</a>
      </div>
     
    </div>
  </div>

@endif
</div>