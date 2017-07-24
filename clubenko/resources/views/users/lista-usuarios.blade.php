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
                <div class="panel-heading">Usuarios</div>
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th>Nombre</th>
					      <th>E-mail</th>
					      <th>Rol</th>
					      <th></th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($data['usuarios'] as $usuario)
					    <tr>
					      <td>{!! $usuario->name !!}</td>
					      <td>{!! $usuario->email !!}</td>
					      <td>{!! $usuario->role->nombre !!}</td>
					      <td>
					      	<span style="display:inline-block;"><a class="btn btn-default" href="{!! route('usuarios.show', $usuario->slug) !!}">Ver usuario</a></span>
					      	<span style="display:inline-block;"><a class="btn btn-default" href="{!! route('usuarios.edit', $usuario->slug) !!}">Editar</a></span>
					    	<span style="display:inline-block;" onclick="return confirm('¿Seguro que quiere borrar este usuario?')">{{ Form::open(array('method' => 'DELETE', 'route' => array('usuarios.destroy', $usuario->slug))) }}
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
