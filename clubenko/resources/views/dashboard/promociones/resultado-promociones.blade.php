<div class="resultado-cupones">
    @if(Auth::user()->cupon()->first() == '' || $data['promociones']->first() == '')        
        <div class="row">
            <div class="col-md-12">
                <div class="blanco">
                    <p>Aún no tiene ningún promoción.</p>
                </div>
            </div>
        </div>
    @endif
    @foreach ($data['promociones']->chunk(3) as $chunk)
        <div class="row gris">
            @foreach ($chunk as $promocion)
            <div class="col-md-4">
                <div class="promo">
                    @include('includes.promocion-editar')
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
</div>