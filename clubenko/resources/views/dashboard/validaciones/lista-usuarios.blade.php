@extends('layouts.app')

@section('content')

<div class="container" id="content">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

  	@include('dashboard.validaciones.includes.submenu')

  	<div class="listado-validaciones">
  		@foreach($data['usuarios'] as $usuario)
  		<div class="row">
  			<div class="col-md-4">
  				<ul class="elemento">
  					<li class="nombre-elemento">{!! $usuario->name !!}</li>
  					<li>{!! $usuario->dni !!}</li>
  					<li>{!! $usuario->email !!}</li>
  				</ul>
  			</div>
  			<div class="col-md-4">
  				<p class="elemento">{!! $usuario->role->nombre !!}</p>
  			</div>
  			<div class="botones">
				
				<span style="display:inline-block;" >
					{{ Form::open(array('method' => 'DELETE', 'route' => array('usuarios.destroy', $usuario->id))) }}
          <button class="btn btn-blue" onclick="return confirm('¿Seguro que quiere borrar este usuario?')">Borrar</button> 
				</span>
				
  				<span><a class="btn btn-green" href="{!! route('validar-usuarios', $usuario->id) !!}">Validar</a><span>

  			</div>
  		</div>
  		@endforeach
  	</div>

</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-usuarios li').addClass('active');
    $('.v-usuarios').removeClass('hidden');
  </script>
@endsection
