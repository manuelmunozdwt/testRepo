@extends('layouts.app')

@section('content')

<div id="content">
    <div class="container" id="mi-cuenta">
        <div class="row">
            <div class="col-xs-12 section-title usuario">
                <p>Mi cuenta</p>
            </div>
        </div>

        <div class="row datos-usuario">
            <div class="col-xs-4">
                <p><strong>Nombre: </strong>{!! $data['mis-datos']->name !!}</p>
                <p><strong>Apellidos: </strong>{!! $data['mis-datos']->apellidos !!}</p>
                <p><strong>Nombre Comercio: </strong> {!! $data['mis-datos']->nombre_comercio !!}</p>
            </div>
            <div class="col-xs-4">
                <p><strong>DNI: </strong>{!! $data['mis-datos']->dni !!}</p>
                <p><strong>Email: </strong>{!! $data['mis-datos']->email !!}</p>
                <p><strong>Rol: </strong>{!! $data['mis-datos']->role->nombre !!}</p>
            </div>
            <div class="col-xs-4">
                @if($data['mis-datos']->imagen !='')  
                    <img src="{!! asset($data['mis-datos']->imagen)!!}">
                @else
                    <img src="{!! asset('img/user.png') !!}">
                @endif
            </div>
        </div>

        <div class="row botones-usuario">
            <a class="editar" href="{{ route('usuarios.edit', $data['mis-datos']->slug) }}">Editar mis datos</a>
        </div>
    </div>

    @include('dashboard.includes.permisos')

</div>

@endsection
