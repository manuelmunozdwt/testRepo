@extends('layouts.app')

@section('CSSHeader')
<style type="text/css">
.botones {
    width: 430px !important;
}
</style>
@endsection

@section('content')

<div class="container" id="content">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

  	@include('dashboard.validaciones.includes.submenu')

  	<div class="listado-validaciones">
		@foreach($data['comentarios'] as $comentario)
		<div class="row">
			<div class="col-md-6">
				<ul class="elemento">
					<li class="nombre-elemento">{!! $comentario->usuario->name !!}</li>
					<li>{!! $comentario->comentario !!}</li>
				</ul>
			</div>
			<div class="col-md-4">
				<ul class="elemento">
					<li class="nombre-elemento">Cupón</li>
					<li><a href="{{ route('cupones.show',$comentario->cupon->slug) }}" title="" target="_blank">{!! $comentario->cupon->titulo !!}</a></li>
				</ul>
			</div>
			<div class=" botones">
				<span><a class="btn btn-green" href="{!! route('validar-comentario', $comentario->id) !!}">Validar</a></span>

				<span><a class="btn btn-blue" href="{!! route('comentarios.edit', $comentario->id) !!}">Editar</a></span>

				<span style="display:inline-block;" onclick="return confirm('¿Seguro que quiere borrar este comentario?')">{{ Form::open(array('method' => 'DELETE', 'route' => array('comentarios.destroy', $comentario->id))) }}
							{{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
						{{ Form::close() }}</span>

			</div>
		</div>
		@endforeach
		{{ $data['comentarios']->links() }}

  	</div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-comentarios li').addClass('active');
    $('.v-comentarios').removeClass('hidden');
  </script>
@endsection
