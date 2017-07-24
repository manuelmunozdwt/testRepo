@if($cupon->fecha_fin < $now)
	<a href="{!! route('home_ver_cupon', $cupon->slug) !!}"><div class="caducado"><p>OFERTA CADUCADA</p></div></a>
@endif
<div class="brand">
	@if($cupon->logo == 'logo')
	<div class='logo-tienda'>
		@if($cupon->tienda->first()->usuario()->first()->imagen == '')
			<a href="{!! route('comercio', $cupon->tienda->first()->slug) !!}"><img src="{!! asset('/img/600x600.png') !!}" width="120px"></a>		

		@else
			<a href="{!! route('comercio', $cupon->tienda->first()->slug) !!}"><img src="{!! asset($cupon->tienda->first()->usuario()->first()->imagen) !!}" width="120px"></a>
		@endif
	</div>
	@elseif($cupon->logo == 'blanco')
	<div class="logo-blanco">
		<a href="{!! route('comercio', $cupon->tienda->first()->slug) !!}">{{$cupon->tienda->first()->usuario()->first()->name}}</a>
	</div>
	@elseif($cupon->logo == 'negro')
	<div class="logo-negro">
		<a href="{!! route('comercio', $cupon->tienda->first()->slug) !!}">{{$cupon->tienda->first()->usuario()->first()->name}}</a>
	</div>
	@endif
</div>
<a href="{!! route('home_ver_cupon', $cupon->slug) !!}">
	<img src="{!! asset('img/cupones/'.$cupon->imagen) !!}">
</a>
<div class="datos-cupon">
	<div class="tipo-descuento">
		<p>{!! $cupon->filtro->nombre !!}</p>
	</div><div class="datos-descuento">
		<p class="cupon-titulo"><a href="{!! route('home_ver_cupon', $cupon->slug) !!}">{!! $cupon->titulo !!}</a></p>
		<p class="cupon-descripcion"><a href="{!! route('home_ver_cupon', $cupon->slug) !!}">{!! $cupon->descripcion_corta !!}</a></p>
	</div>    	
</div>