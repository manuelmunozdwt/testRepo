<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="visualizacion-cupon" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    {{-- imagen de cerrar provisional hasta que nos pase Miriam el aspa --}}
    <img class="cerrar" data-dismiss="modal" src="{!! asset('img/cerrar.png')!!}">
    <div class="modal-content modal-visualizacion-cupon">
      <div class="modal-body">
        <div class="row">
            <style>
                .modal-body{
                    padding: 0px;
                }
                .modal-body .row{
                    margin: 0;
                }
            </style>
            <div class="col-md-4 texto-visualizacion-cupon">
                <p style="margin-top:50%">Así es como quedaría el cupón que has creado</p>
                <p>Recuerda que una vez creado y validado puedes volver a editarlo en editar mis cupones</p>
            </div>
            <div class="col-md-8 resultado-cupon">
                <div class="visualizacion-cupon">
                    <div class="brand" id="brand">
                        
                    </div>

                    <span id='imagen-cupon'></span>
                    <div class="datos-cupon">
                        <div class="tipo-descuento">
                            <p id='tipo-descuento'></p>
                        </div>
                        <div class="datos-descuento">
                            <p class="cupon-titulo" id="titulo-cupon"></p>

                            <p class="cupon-descripcion" id="descripcion-cupon"></p>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>