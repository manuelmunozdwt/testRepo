    
@extends('layouts.app')

@section('content')
<div class="container" id="content">
    <div class="row">
        <div class="col-md-12">
        	@if(session('status'))
        		<div class="alert alert-success">
        			{!! session('status') !!}
        		</div>
        	@endif
            <div class="panel panel-default">
                <div class="panel-heading">Tiendas</div>
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th>Nombre</th>
					      <th>Dirección</th>
					      <th>Confirmado</th>
					      <th></th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($data['tiendas'] as $tienda)
					    <tr>
					      <td>{!! $tienda->nombre !!}</td>
					      <td>{!! $tienda->direccion !!}</td>
					      <td>{!! $tienda->confirmado !!}</td>
					      <td>
					      	<span style="display:inline-block;"><a class="btn btn-default" href="{!! route('tiendas.edit', $tienda->slug) !!}">Editar</a></span>
					    	<span style="display:inline-block;" onclick="return confirm('¿Seguro que quiere borrar esta tienda?')">{{ Form::open(array('method' => 'DELETE', 'route' => array('tiendas.destroy', $tienda->slug))) }}
								{{ Form::submit('Borrar', array('class' => 'btn btn-danger')) }}
							{{ Form::close() }}</span>
						  </td>

					    </tr>	
					    @endforeach
					  </tbody>
					</table>
            </div>
        </div>
    </div>
</div>
   
@endsection
