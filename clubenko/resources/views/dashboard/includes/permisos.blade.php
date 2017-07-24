@if(es_administrador(Auth::user()))
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">El usuario {!! $data['mis-datos']->name !!} puede:</div>
                <div class="panel-body">
                    {!! Form::model($data['mis-datos'], [
                        'method' => 'POST',
                        'route' => ['permisos-update', $data['mis-datos']->slug]
                    ]) !!}   
                    @foreach($data['permisos'] as $permiso)
                    <div class="col-md-10"> {!! $permiso->nombre !!}</div>
                    <div class="col-md-2">
                        <div class="onoffswitch">
                          {!!Form::checkbox('permiso[]', $permiso->id, in_array($permiso->id, $data['array-permisos']), array('class' => 'onoffswitch-checkbox', 'id' => 'myonoffswitch'.$permiso->id ))!!} 
                            <label class="onoffswitch-label" for="myonoffswitch{!! $permiso->id !!}">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    @endforeach
                    <button type="submit" class="btn btn-default"> Modificar permisos</button>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endif