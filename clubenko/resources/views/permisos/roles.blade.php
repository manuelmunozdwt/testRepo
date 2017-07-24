@extends('layouts.app')

@section('content')

<div class="container" id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Permisos</div>
                <div class="panel-body">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Rol</th>

                          <th>Permisos</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['roles'] as $rol)
                            <tr>
                              <td>{!! $rol->nombre !!}</td>
                              <td>
                                <ul>
                                @foreach($rol->permiso as $permiso)
                                <li>{!! $permiso->nombre !!}</li>
                                @endforeach
                                </ul>
                              </td>
                              <td>                        
                                <a class="btn btn-default" href="{!! route('roles.show', $rol->id) !!}">Editar</a>
                              </td> 
                            </tr>   
                        @endforeach
                      </tbody>
                    </table>
                    <div class="col-md-12">
                        <a class="btn btn-default" href="{!! route('roles.create') !!}">Nuevo rol</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
