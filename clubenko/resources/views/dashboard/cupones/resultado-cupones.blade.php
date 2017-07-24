<div class="resultado-cupones">
    @if(Auth::user()->cupon()->first() == '' || $data['cupones']->first() == '')        
        <div class="row">
            <div class="col-md-12">
                <div class="blanco">
                    <p>Aún no tiene ningún cupón.</p>
                </div>
            </div>
        </div>
    @endif
    @foreach ($data['cupones']->chunk(3) as $chunk)
        <div class="row gris">
            @foreach ($chunk as $cupon)
            <div class="col-md-4">
                <div class="promo">
                    @include('includes.cupon-editar')
                </div>
            </div>
            @endforeach
        </div>
    @endforeach
</div>