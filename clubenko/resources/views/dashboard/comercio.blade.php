@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Datos de {!! $data['mis-datos']->name !!}</div>
                <div class="panel-body">
                    <span class="col-md-2">Nombre: </span>  <span class="col-md-10"> {!! $data['mis-datos']->name !!}</span>
                    <span class="col-md-2">E-mail: </span>  <span class="col-md-10"> {!! $data['mis-datos']->email !!}</span>
                    <span class="col-md-2">Rol: </span>  <span class="col-md-10"> {!! $data['mis-datos']->role->nombre !!}</span>
                    <div class="col-md-12">
                        @if($data['mis-datos']->imagen !='')  
                        <img src="{!! asset($data['mis-datos']->imagen)!!}">
                        @endif
                    </div>
                    <div class="col-md-12">
                        <a class="btn btn-default" href="{{ route('usuarios.edit', $data['mis-datos']->slug) }}">Editar datos</a>
                        @if(Auth::user()->rol ==1)
                        <a class="btn btn-default" href="{{ route('mis-cupones', $data['mis-datos']->slug) }}">Ver mis cupones</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->rol == '3')
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
    @endif
    @if(Auth::user()->rol != '1')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mi tienda</div>
                <div class="panel-body">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Nombre</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['mis-datos']->tienda as $tienda)
                            @if($data['mis-datos']->tienda()->first() != null)
                                @if($tienda->confirmado == 1 )
                                <tr>
                                  <td>{!! $tienda->nombre !!}</td>

                                  <td>
                                    <a class="btn btn-default" href="{{ route('tiendas.show', $tienda->slug) }}">Ver tienda</a>
                                    <a class="btn btn-default" href="{{ route('tiendas.edit', $tienda->slug) }}">Editar</a>
                                    <a class="btn btn-default" href="{{ route('comercio', $tienda->slug) }}">Vista pública</a>
                                  </td>
                                </tr>   
                                @endif
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="col-md-12">
                        <a class="btn btn-default" href="{{ route('tiendas.create') }}">Nueva tienda</a>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mis cupones</div>
                <div class="panel-body">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Nombre</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['mis-datos']->cupon as $cupon)
                            @if($cupon->confirmado == 1 )
                            <tr>
                              <td>{!! $cupon->titulo !!}</td>
                              <td>{!! $cupon->slug !!}</td>
                              <td>
                                @foreach($cupon->tienda as $tienda)
                                    <ul>
                                        <li>{!! $tienda->nombre!!}</li>
                                    </ul>
                                @endforeach
                              </td>
                              <td>
                                <a class="btn btn-default" href="{{ route('cupones.show', $cupon->slug) }}">Ver cupón</a>
                                <a class="btn btn-default" href="{{ route('cupones.edit', $cupon->slug) }}">Editar</a>
                              </td>
                            </tr>   
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="col-md-12">
                        <a class="btn btn-default" href="{{ route('cupones.create') }}">Nuevo cupón</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
