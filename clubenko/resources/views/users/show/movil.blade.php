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
            <div class="col-xs-7">
                <p>{!! $data['mis-datos']->name !!}</p>
                <p>{!! $data['mis-datos']->dni !!}</p>
                <p>{!! $data['mis-datos']->email !!}</p>
                <p>{!! $data['mis-datos']->role->nombre !!}</p>
            </div>
            <div class="col-xs-5">
                @if($data['mis-datos']->imagen !='')  
                    <img src="{!! asset($data['mis-datos']->imagen)!!}">
                @else
                    <img src="{!! asset('img/user.png') !!}">
                @endif
            </div>
        </div>

        <div class="row botones-usuario">
            <a class="editar" href="{{ route('usuarios.edit', $data['mis-datos']->slug) }}">Editar mis datos</a>
            {{--@if(Auth::user()->rol ==1)
            <a class="ver-cupones" href="{{ route('mis-cupones', $data['mis-datos']->slug) }}">Ver mis cupones</a>
            @endif--}}
        </div>
    </div>

    @include('dashboard.includes.permisos')

</div>

@endsection
