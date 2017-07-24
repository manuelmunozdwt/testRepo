@extends('layouts.app')

@section('CSSHeader')

<style type="text/css">
    #header, #footer{
        display: none;

    }
</style>
@section('content')
<div class=" container" id="content">

    <div class="row back">
        <div class="col-xs-12">
        	<div class="">
                <a href="{!! URL::previous() !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-xs-12">
			<div class="comentarios">
                <div class="logo-cupon">
                    @if($data['cupon']->logo == 'logo')
                    <div class='logo-tienda'>
                        @if($data['cupon']->tienda->first()->usuario()->first()->imagen == '')
                            <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}"><img src="{!! asset('/img/600x600.png') !!}" width="120px"></a>      

                        @else
                            <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}"><img src="{!! asset($data['cupon']->tienda->first()->usuario()->first()->imagen) !!}" width="120px"></a>
                        @endif
                    </div>
                    @elseif($data['cupon']->logo == 'blanco')
                    <div class="logo-blanco">
                        <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}">{{$data['cupon']->tienda->first()->usuario()->first()->name}}</a>
                    </div>
                    @elseif($data['cupon']->logo == 'negro')
                    <div class="logo-negro">
                        <a href="{!! route('comercio', $data['cupon']->tienda->first()->slug) !!}">{{$data['cupon']->tienda->first()->usuario()->first()->name}}</a>
                    </div>
                    @endif

                </div>
				<div class="tipo-descuento">
					<p>{!! $data['cupon']->filtro->nombre !!}</p>
				</div><div class="datos-descuento">
					<p class="cupon-titulo"><a href="{!! route('cupones.show', $data['cupon']->slug) !!}">{!! $data['cupon']->titulo !!}</a></p>
					<p class="cupon-descripcion"><a href="{!! route('cupones.show', $data['cupon']->slug) !!}">{!! $data['cupon']->descripcion_corta !!}</a></p>
				</div>    	
			</div>

		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>

            @elseif ($errors->has('comentario'))
                <span class="help-block">
                    <strong>{!! $errors->first('comentario') !!}</strong>
                </span>
            @endif

            @if ($comentario_existe == null) 

                @if(Auth::check())
                <div class="form-group comentarios">
                    {!! Form::open(['route' => 'comentarios.store']) !!}
                    {!! Form::hidden('cupon_id', $data['cupon']->id) !!}
                    {!! Form::text('comentario', '', array('class' => 'form-control', 'placeholder' => 'Deja tu comentario')) !!}
                    {!! Form::submit( 'Enviar', array('class' => 'btn-comentario'))!!}
                    {!! Form::close() !!}
                </div>
                @else
                <div class="form-group comentarios">
                    <p class="form-control"><a href="{!! route('login') !!}">Conéctate para dejar un comentario</a></p>
                </div>
                @endif
            @endif
		</div>
	</div>

    <div class="row comentarios">
    	<div class="col-xs-12 ">
    		<p>Todos los comentarios sobre la oferta</p>

    	</div>
		@if(empty($data['comentarios']->first()))
            <div class="col-xs-12 section-description">
                <div class=" comentario">
                    <p>Todavía no existen comentarios en esta oferta. ¡Sé el primero en dejarnos tu opinión!</p>
                </div>
            </div>

        @else
            @foreach($data['comentarios'] as $comentario)
            <div class="col-xs-12 section-description">
                <div class=" comentario">
                    <div class="col-xs-3 autor">
                        @if($comentario->usuario->imagen == null)
                        <img  src="{!! asset ('/img/icono_user.png') !!}">
                        @else
                         <img class="imagen_usuario" src="{!! asset ($comentario->usuario->imagen) !!}">
                        @endif
                        <p class="nombre">{!! $comentario->usuario->name!!}</p>
                    </div>
                    <div class="col-xs-9 comment">
                        {!! $comentario->comentario !!}
                    </div>
                </div>
            </div>
            @endforeach
 
        @endif
    </div>


</div>

@endsection