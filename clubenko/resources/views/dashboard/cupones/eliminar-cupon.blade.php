@extends('layouts.app')

@section('content')

{!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}
   
{!! Html::style('css/jquery-ui.css') !!}
{!! Html::style('css/jquery-ui.min.css') !!}
{!! Html::style('css/jquery-ui.structure.css') !!}
{!! Html::style('css/jquery-ui.structure.min.css') !!}
{!! Html::style('css/jquery-ui.theme.css') !!}
{!! Html::style('css/jquery-ui.theme.min.css') !!}

<div class="container">
    <!-- Submenu comercio -->
    <div class="row">
        <div class="col-md-12">
            <div class="submenu-comercio">
                <ul class="submenu-item-list">
                    <a class="listado" href="{!! route('listar-cupones', Auth::user()->slug) !!}"><li>LISTADO DE MIS CUPONES</li></a>
                    <a class="creacion" href="{!! route('cupones.create') !!}"><li class="">NUEVO CUPÓN</li></a>
                    <a class="edicion" href=""><li>EDITAR MIS CUPONES</li></a>
                </ul>
                <div class="submenu-item-description">
                    <div class="edicion hidden">
                        <div class="promo">
                            @include('includes.cupon', ['cupon' => $data['cupon']])
                        </div>
                        <div class="enlaces">
                            <div class="editar"><a href="{!! route('cupones.edit', $data['cupon']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="duplicar"><a href="{!! route('duplicar-cupon', $data['cupon']->slug) !!}"><img src="{!! asset('img/duplicar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('borrar-cupon', $data['cupon']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                          
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin submenu comercio -->
        <!-- Formulario -->
   {!! Form::model($data['cupon'],[
        'method' => 'DELETE',
        'route' => ['cupones.destroy', $data['cupon']->slug],
        'files' => true
    ]) !!}   
    <div class="row gris-oscuro botones">
        <div class="col-md-12">
            {!! Form::submit('Eliminar cupón', array('class' => 'btn-blue'))!!}
            <p class="delete-title">Eliminar permanentemente este cupón</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('JSpage')
    <script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>
    <script type="text/javascript">
        

    var $tiendas_cupon = $(".js-example-basic-multiple").select2();
    $tiendas_cupon.val(
            [@foreach($data['cupon']->tienda as $tienda)
                "{{$tienda->id}}",
             @endforeach]
            ).trigger("change");
    </script>

  <script type="text/javascript">
    $('.radio-icon').on('click', function(){
        $('.radio-icon').css('width', '40px').css('margin-top', '0px');
        $(this).css('width', '100px')
        $(this).css('margin-top', '-12px');
    });

    $('.edicion li').addClass('active');
    $('div .borrar').css('background', '#fff');
    $('div.edicion').removeClass('hidden');
  </script>

@endsection