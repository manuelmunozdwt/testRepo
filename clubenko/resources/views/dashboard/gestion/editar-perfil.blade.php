@extends('layouts.app')

@section('content')

@section('CSSHeader')
<style type="text/css">
    .ezdz-dropzone{
        height: auto;
        border: none !important;
    }
</style>
@endsection

<div class="container">
    <!-- Submenu -->

    <div class="row">
        <div class="col-md-12">
            <div class="submenu-comercio">
                <ul class="submenu-item-list">
                    <a class="listado" href="{!! route('usuarios.show', Auth::user()->slug) !!}"><li>MIS DATOS</li></a>
                    <a class="edicion" href="{!! route('usuarios.edit', Auth::user()->slug) !!}"><li class="">EDITAR DATOS</li></a>
                    @if(Auth::user()->rol == '3')
                    <a class="editorhome" href="{!! route('bloques.index') !!}"><li class="">EDITAR PÁGINA DE INICIO</li></a>
                    @endif
                </ul>
                <div class="submenu-item-description">
                    <p class="listado hidden">Mi perfil te permite ver todos los datos correspondientes a tu usuario.</p>

                    <p class="edicion hidden">Aquí puedes actualizar todos tus datos de usuario.</p>                   

                    <p class="editorhome hidden">Aquí puedes editar los bloques y cupones de la página de inicio.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin submenu -->
    {!! Form::model($data['mis-datos'], [
        'method' => 'PATCH',
        'route' => ['usuarios.update', $data['mis-datos']->slug], 
        'files' => true
    ]) !!}   
    {!! csrf_field() !!}
    <div class="row perfil">

        <div class="col-md-6 gris-oscuro">
            <div class="datos-tienda"> 
                <div class="form-group">
                    {!! Form::file('logo', array('id' => 'imagen')) !!}
                </div>
            </div>        
        </div>
        <div class="col-md-6 blue">
            <div class="datos-tienda">
              <p>{!! Form::text('nombre', $data['mis-datos']->name, array('class' => 'form-control',  'placeholder' => 'Nombre')) !!}</p>
              <p>{!! Form::text('email', $data['mis-datos']->email, array('class' => 'form-control',  'placeholder' => 'E-mail')) !!}</p>
              <p>{!! Form::text('nombre', $data['mis-datos']->dni, array('class' => 'form-control',  'placeholder' => 'Nombre', 'disabled' => true)) !!}</p>
            </div>
        </div>
        
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row perfil">
        <div class="col-md-12 blanco">
            <button type="submit" class="submit-datos">Guardar cambios</button>
        </div>
    </div>
        
        {!! Form::close() !!}
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.edicion li').addClass('active');
    $('p.edicion').removeClass('hidden').css('margin-top', '60px');

    $('input[type="file"]').ezdz({
        text: "<img src={!! asset ('/img/arrastre-su-logo.png') !!} style='width:100%; height:100%'>",
    });
  </script>
@endsection