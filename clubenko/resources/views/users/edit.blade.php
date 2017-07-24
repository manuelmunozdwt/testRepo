@extends('layouts.app')


@section('content')


<div id="content">
    <div class="container" id="mi-cuenta">
        {!! Form::model($data['mis-datos'], [
            'method' => 'PATCH',
            'route' => ['usuarios.update', $data['mis-datos']->slug], 
            'files' => true
        ]) !!}   
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-xs-12 section-title usuario">
                <p>Editar mis datos</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @if($data['mis-datos']->imagen !='')  
                    <img class="imagen-usuario" src="{!! asset($data['mis-datos']->imagen)!!}">
                @else
                    <img class="imagen-usuario" src="{!! asset('img/user.png') !!}">
                @endif
            </div>
        </div>

        <div class="row botones-usuario">
            <a class="gris editar" role="button" data-toggle="collapse" href="#cambiar-foto" aria-expanded="false" aria-controls="cambiar-foto">Cambiar foto</a>
        </div>  


        <div class="row collapse" id="cambiar-foto">
            <div class="">
                <div class="form-group">
                    {!! Form::file('logo', array('id' => 'logo')) !!}
                </div>
            </div>
        </div>
        
        <div class="row datos-usuario editar">
            <div class="col-xs-12">
                <label for="Nombre">Nombre</label>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::text('nombre', $data['mis-datos']->name, array('class' => 'form-control',  'placeholder' => 'Nombre')) !!}
                    <div class="col-md-6">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{!! $errors->first('name') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <label for="Apellidos">Apellidos</label>
                <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                    {!! Form::text('apellidos', $data['mis-datos']->apellidos, array('class' => 'form-control',  'placeholder' => 'Apellidos')) !!}
                    <div class="col-md-6">

                        @if ($errors->has('apellidos'))
                            <span class="help-block">
                                <strong>{!! $errors->first('apellidos') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                @if(Auth::user()->rol != 1)
                    <label for="Nombre del Comercio">Nombre del Comercio</label>
                    <div class="form-group{{ $errors->has('nombre_comercio') ? ' has-error' : '' }}">
                        {!! Form::text('nombre_comercio', $data['mis-datos']->nombre_comercio, array('class' => 'form-control',  'placeholder' => 'Nombre del Comercio')) !!}
                        <div class="col-md-6">

                            @if ($errors->has('nombre_comercio'))
                                <span class="help-block">
                                    <strong>{!! $errors->first('nombre_comercio') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                
                    <div class="form-group{{ $errors->has('sobre_comercio') ? ' has-error' : '' }}">
                        {!! Form::label('sobre_comercio', 'Sobre el Comercio', array('class', 'control-label')) !!}
                        {!! Form::textarea('sobre_comercio', $data['mis-datos']->sobre_comercio, array('class' => 'form-control',  'placeholder' => 'Sobre el Comercio')) !!}
                        <div class="col-md-6">
                            @if ($errors->has('sobre_comercio'))
                                <span class="help-block">
                                    <strong>{!! $errors->first('sobre_comercio') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('web_comercio') ? ' has-error' : '' }}">
                        {!! Form::text('web_comercio', $data['mis-datos']->web_comercio, array('class' => 'form-control',  'placeholder' => 'Web del Comercio')) !!}
                        <div class="col-md-6">
                            @if ($errors->has('web_comercio'))
                                <span class="help-block">
                                    <strong>{!! $errors->first('web_comercio') !!}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                
    
                <label for="Email">Email</label>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::text('email', $data['mis-datos']->email, array('class' => 'form-control',  'placeholder' => 'Email')) !!}
                    <div class="col-md-6">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{!! $errors->first('email') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <label for="Nueva Contraseña">Nueva Contraseña</label>
                <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                    <input type="password" class="form-control" name="password" placeholder="Nueva contraseña">
                    <div class="col-md-6">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{!! $errors->first('password') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <label for="Confirme su contraseña">Confirme su contraseña</label>
                <div class="form-group{!! $errors->has('password_confirmation') ? ' has-error' : '' !!}">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirme su contraseña">
                    <div class="col-md-6">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{!! $errors->first('password_confirmation') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                

            </div>


        </div>
        @if(es_administrador(Auth::user()))
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group">
                    {!! Form::label('rol', 'Rol', array('class', 'control-label')) !!}

                    <select class="form-control" name="rol">
                        <option value="{!! $data['mis-datos']->rol !!}">{!! $data['mis-datos']->role->nombre !!} - actualmente</option>
                        @foreach($data['roles'] as $rol)
                        <option value="{!! $rol->id !!}">{!! $rol->nombre !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif

        <div class="row submit">
            <div class="col-md-12">
                <button type="submit" class="submit-datos">Guardar cambios</button>
            </div>
        </div>
        {!! Form::close() !!}

        @include('dashboard.includes.permisos')
    </div>
</div>
@endsection

@section('JSpage')
    <script type="text/javascript">
        $('input[type="file"]').ezdz({
          text: "<img src={!! asset ('/img/arrastre-imagen.png') !!} style='width:100%; height:100%'>",
        });
    </script>
@endsection
