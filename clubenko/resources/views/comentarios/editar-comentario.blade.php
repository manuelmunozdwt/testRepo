@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Comentario</div>
                <div class="panel-body">
				   {!! Form::model($data['comentario'],[
				        'method' => 'PATCH',
				        'route' => ['comentarios.update', $data['comentario']->id]
				    ]) !!} 
				    <div class="form-group">
				    	{!! Form::text('comentario', $data['comentario']->comentario, ['class' => 'form-control'] )!!}
				    </div>
				    <div class="form-group">
				    	{!! Form::submit('Guardar', ['class' => 'btn btn-default']) !!}
				    </div>
				    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
