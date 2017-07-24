@if($promocion->fecha_fin < $now)
	<a href="{!! route('home_ver_promocion', $promocion->slug) !!}"><div class="caducado"><p>OFERTA CADUCADA</p></div></a>
@endif
<div class="brand">
	@if($promocion->logo == 'logo')
	<div class='logo-tienda'>
		@if($promocion->tienda->first()->usuario()->first()->imagen == '')
			<a href="{!! route('comercio', $promocion->tienda->first()->slug) !!}"><img src="{!! asset('/img/600x600.png') !!}" width="120px"></a>		

		@else
			<a href="{!! route('comercio', $promocion->tienda->first()->slug) !!}"><img src="{!! asset($promocion->tienda->first()->usuario()->first()->imagen) !!}" width="120px"></a>
		@endif
	</div>
	@elseif($promocion->logo == 'blanco')
	<div class="logo-blanco">
		<a href="{!! route('comercio', $promocion->tienda->first()->slug) !!}">{{$promocion->tienda->first()->usuario()->first()->name}}</a>
	</div>
	@elseif($promocion->logo == 'negro')
	<div class="logo-negro">
		<a href="{!! route('comercio', $promocion->tienda->first()->slug) !!}">{{$promocion->tienda->first()->usuario()->first()->name}}</a>
	</div>
	@endif
</div>
<a href="{!! route('home_ver_promocion', $promocion->slug) !!}">
	<img src="{!! asset('img/cupones/'.$promocion->imagen) !!}">
</a>
<div class="datos-promocion">
	<div class="tipo-descuento">
		<p>{!! $promocion->filtro->nombre !!}</p>
	</div><div class="datos-descuento">
		<p class="promocion-titulo"><a href="{!! route('home_ver_promocion', $promocion->slug) !!}">{!! $promocion->titulo !!}</a></p>
		<p class="promocion-descripcion"><a href="{!! route('home_ver_promocion', $promocion->slug) !!}">{!! $promocion->descripcion_corta !!}</a></p>
	</div>    	
</div>