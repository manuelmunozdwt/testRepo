@extends('layouts.app')

@section('content')

<div class="container" id="content">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Crear nuevo rol</div>
                <div class="panel-body">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['roles.store']
                    ]) !!}   

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('nombre', 'Nombre', array('class', 'control-label')) !!}
                        {!! Form::text('nombre', null, array('class' => 'form-control',  'placeholder' => 'Nombre')) !!}
                        <div class="col-md-6">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('descripcion', 'Descripción', array('class', 'control-label')) !!}
                        {!! Form::text('descripcion', null, array('class' => 'form-control')) !!}
                        <div class="col-md-6">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('permiso', 'Asignar permisos a este rol') !!}
                        @foreach($data['permisos'] as $permiso)
                        <span class="col-md-12">
                            {!! Form::checkbox('permiso[]', $permiso->id)!!} {!!$permiso->nombre!!}
                        </span>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-default">Guardar</button>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
                        
    </div>
</div>

@endsection
