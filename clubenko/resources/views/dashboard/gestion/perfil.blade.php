@extends('layouts.app')

@section('content')

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
    <div class="row perfil">
        <div class="col-md-6 gris-oscuro">
            <div class="datos-tienda">                        
                @if($data['mis-datos']->imagen == '')
                <img src="{!! asset('/img/600x600.png') !!}">
                @else
                <img src="{!! asset(Auth::user()->imagen) !!}">
                @endif
            </div>
        </div>

        <div class="col-md-6 blue">
            <div class="datos-tienda">
              <p>{!! $data['mis-datos']->name !!}</p>
              <p>{!! $data['mis-datos']->email !!}</p>
              <p>{!! $data['mis-datos']->dni !!}</p>
            </div>
        </div>

    </div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.listado li').addClass('active');
    $('p.listado').removeClass('hidden');
  </script>
@endsection