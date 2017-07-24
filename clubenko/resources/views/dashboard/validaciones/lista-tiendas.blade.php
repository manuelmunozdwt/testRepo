@extends('layouts.app')

@section('content')

<div class="container" id="content">

	@include('dashboard.validaciones.includes.submenu')

	<div class="listado-validaciones">
	    @foreach($data['tiendas'] as $tienda)
	    <div class="row">
	        <div class="col-md-3">
	        	@if($tienda->usuario()->first()->imagen == '')
	        		<img src="{!! asset('img/600x600.png') !!}" class="imagen-elemento">
	        	@else
	        		<img src="{!! asset($tienda->usuario()->first()->imagen) !!}" class="imagen-elemento">
	        	@endif
	        </div>
	        <div class="col-md-5">
	        	<ul class="elemento">
	        		<li class="nombre-elemento">{!! $tienda->nombre !!}</li>
	        		<li>{!! $tienda->direccion !!}</li>
	        		<li>{!! $tienda->telefono !!}</li>
	        		<li>{!! $tienda->web !!}</li>
	        	</ul>
	        </div>
	        <div class="botones">
		    	<span  onclick="return confirm('¿Seguro que quiere borrar esta tienda?')">{{ Form::open(array('method' => 'DELETE', 'route' => array('tiendas.destroy', $tienda->slug))) }}
					{{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
				{{ Form::close() }}</span>

				<span><a class="btn btn-green" href="{!! route('validar-tienda', $tienda->slug) !!}">Validar</a></span>
	        </div>
	    </div>
    	@endforeach
	</div>
</div>

@endsection

@section('JSpage')
	<script type="text/javascript">
		$('.v-tiendas li').addClass('active');
		$('.v-tiendas').removeClass('hidden');
	</script>
@endsection