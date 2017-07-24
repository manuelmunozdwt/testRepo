@extends('layouts.app')

@section('content')

<div class="container" id="content">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">El rol {!! $data['rol']->nombre !!} puede:</div>
                <div class="panel-body">
                    {!! Form::model($data['rol'], [
                        'method' => 'PATCH',
                        'route' => ['roles.update', $data['rol']->id]
                    ]) !!}   
                    @foreach($data['permisos'] as $permiso)
                    <span class="col-md-10"> {!! $permiso->nombre !!}</span>
                    <span class="col-md-2">
                        <div class="onoffswitch">
                          {!!Form::checkbox('permiso[]', $permiso->id, in_array($permiso->id, $data['array-permisos']), array('class' => 'onoffswitch-checkbox', 'id' => 'myonoffswitch'.$permiso->id ))!!} 
                            <label class="onoffswitch-label" for="myonoffswitch{!! $permiso->id !!}">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </span>
                    @endforeach
                    <button type="submit" class="btn btn-default"> Modificar permisos</button>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
                        
    </div>
</div>

@endsection
