@extends('layouts.app')

@section('content')

@section('CSSHeader')
{!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}
{!! Html::style(asset('css/image-picker.css') ) !!}

<style type="text/css">
    .ilimitado-box{
        font-weight: 400;
        color: #FFf;
        letter-spacing: 1px;
        margin-top: 30px;
    }
</style>
@endsection
<div class="container" id="duplicar-cupon">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Submenu comercio -->
    <div class="row">
        <div class="col-md-12">
            <div class="submenu-comercio">
                <ul class="submenu-item-list">
                    <a class="listado" href="{!! route('listar-cupones', Auth::user()->slug) !!}"><li>LISTADO DE MIS CUPONES</li></a>
                    <a class="creacion" href="{!! route('cupones.create') !!}"><li class="">NUEVO CUPÓN</li></a>
                    <a class="edicion" href=""><li>EDITAR CUPÓN</li></a>
                </ul>
                <div class="submenu-item-description">
                    <div class="edicion hidden">
                        <p>Edita tu cupón si quieres modificarlo. También puedes editarlo o borrarlo.</p>   

                        <div class="enlaces">
                            <div class="editar"><a href="{!! route('cupones.edit', $data['cupon']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="duplicar"><a href="{!! route('duplicar-cupon', $data['cupon']->slug) !!}"><img src="{!! asset('img/duplicar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('borrar-cupon', $data['cupon']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                          
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gris-medio">
        <div class="col-md-4 col-md-offset-4">
            <div class="promo">
                @include('includes.cupon', ['cupon' => $data['cupon']])
            </div>
        </div>
    </div>
    <!-- Fin submenu comercio -->
    <!-- Formulario -->
   {!! Form::open([
        'method' => 'POST',
        'route' => ['duplicar-cupon', $data['cupon']->slug],
        'files' => true
    ]) !!}   
    <div class="row gris-oscuro">
        <div class="col-md-12">

            <p>Selecciona la categoría donde aparecerá tu cupón</p>
            <div class="form-group categorias">
                @foreach($data['categorias'] as $categoria)
      
                        <div class="radio-box">
                            <label class="radio-icon">
                                <img src="{!! asset($categoria->imagen)!!}">
                                <input class="input-img" data-categoria_slug="{!! $categoria->slug !!}" type="radio" name="categoria_id" value="{!! $categoria->id !!}" @if($categoria->id == $data['cupon']->categoria_id) checked="true" @endif/>
                            </label>
                            <p>{!! $categoria->nombre !!}</p>
                        </div>
                
                @endforeach
            </div>        

            <p>Selecciona la subcategoría donde aparecerá tu cupón</p>
            <div class="form-group">
                <div class="radio-subcategorias"  id="radio-subcategorias">
                    @foreach($data['subcategorias'] as $subcategoria)
                    <div class=" subcategoria {!! $subcategoria->categoria_id !!}" id="{!! $subcategoria->id !!}">
                        <input type="radio" name="subcategoria_id" value="{!! $subcategoria->id !!}" class="subcategoria" id="subcat{!! $subcategoria->id !!}" @if($subcategoria->id == $data['cupon']->subcategoria_id) checked="true" @endif></input>
                        <label for="subcat{!! $subcategoria->id !!}"></label>
                        <p>{!! $subcategoria->nombre !!}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    <div class="row gris-medio">
        <div class="col-md-12">
            <div id="contenedor-imagen">
                <div class="form-group">
                    <p>Seleccione una imagen para la oferta o cupón</p>
                    <i class="fa fa-spinner fa-spin fa-5x fa-fw hidden" style="margin-left: 40%;"></i>
                    <div id="elementos-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <div class="blanco">
                <div class="form-group">
                    {!! Form::label('tienda', 'Seleccione las tiendas', array('class', 'control-label')) !!}
                    <select name="tienda[]" class="form-control js-example-basic-multiple" id="id_label_multiple" multiple="multiple" >

                        @foreach($data['tiendas'] as $tienda)
                            <option value="{!! $tienda->id !!}" >{{$tienda->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row gris-medio">
        <div class="fecha form-group col-md-5">
            {!! Form::label('fecha_inicio', 'Fecha de inicio', array('class', 'control-label')) !!}
            {{--!! Form::date('fecha_inicio', $data['cupon']->fecha_inicio, array('class', 'form-control hasDatepicker') !!--}}
            <input id="fecha_inicio" class="form-control" name="fecha_inicio" type="date" value="{!! $data['cupon']->fecha_inicio !!}" placeholder="{!! $data['cupon']->fecha_inicio !!}">
        </div>

        <div class="fecha form-group col-md-5">
            {!! Form::label('fecha_fin', 'Fecha de fin', array('class', 'control-label')) !!}
            <input id="fecha_fin" class="form-control hasDatepicker" name="fecha_fin" type="date"value="{!! $data['cupon']->fecha_fin !!}" placeholder="{!! $data['cupon']->fecha_fin !!}">                        
        </div>

        <div class="fecha form-group col-md-2 ilimitado-box">
            <input type="checkbox" name="ilimitado" id='ilimitado' {!! ($data['cupon']->fecha_fin == '9999-12-31')?'checked' : '' !!}> Ilimitado                        
        </div>
            
    </div>
    <div class="row gris-medio">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                {!! Form::label('titulo', 'Título del cupón', array('class', 'control-label')) !!}
                {!! Form::text('titulo', $data['cupon']->titulo , array('class' => 'form-control')) !!}
                <div class="col-md-6">

                    @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::label('filtro', 'Tipo de descuento') !!}
            <div class="filtro-select">
                <select name="filtro" class="" id="select_filtros">
                    @foreach($data['filtros'] as $filtro)
                    <option name="filtro" value="{!! $filtro->id !!}" @if($filtro->id == $data['cupon']->filtro_id) selected @endif>{!! $filtro->nombre !!}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row gris-medio">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('descripcion_corta', 'Descripción corta', array('class', 'control-label')) !!}
                {!! Form::text('descripcion_corta', $data['cupon']->descripcion_corta , array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="row gris-medio">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('descripcion', 'Descripción completa de la oferta', array('class', 'control-label')) !!}
                {!! Form::textarea('descripcion', $data['cupon']->descripcion , array('class' => 'form-control',  'placeholder' => 'Descripción')) !!}
                <div class="col-md-6">

                    @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row gris-medio">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('condiciones', 'Condiciones del Cupón', array('class', 'control-label')) !!}
                    {!! Form::textarea('condiciones', $data['cupon']->condiciones , array('class' => 'form-control',  'placeholder' => 'Condiciones')) !!}
                    <div class="col-md-6">

                        @if ($errors->has('nombre'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    <div class="row gris-oscuro botones">
        <div class="col-md-12">
            {!! Form::submit('Duplicar cupón', array('class' => 'btn-blue'))!!}
            <p class="delete-title">Duplicar el cupón. Recuerda que podrás ver todos los cupones en la sección de listado de mis cupones.</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('JSpage')
    <script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>

    {{-- Incluimos JS para la carga dinámica de las imágenes --}}
    @include('dashboard.includes.js')

    <script type="text/javascript">
        
        var $tiendas_cupon = $(".js-example-basic-multiple").select2();
        $tiendas_cupon.val(
            [@foreach($data['cupon']->tienda as $tienda)
                "{{$tienda->id}}",
             @endforeach]
            ).trigger("change");
    </script>

    <script src="{!! asset('js/vue.js') !!}"></script>
    <script type="text/javascript">
        new Vue({
          el: '#bar',
          data: {
            message: '{!! $data['cupon']->filtro->nombre!!}',
            
          }
        });
    </script>
    
  <script type="text/javascript">
    $('.radio-icon').on('click', function(){
        $('.radio-box').removeClass('radio-box-active');
        $(this).parent('.radio-box').addClass('radio-box-active');
    });
    $('input[name=categoria]:checked').parents('.radio-box').addClass('radio-box-active');
    $('.edicion li').addClass('active');
    $('div .duplicar').css('-webkit-filter',' invert(100%)').css('-webkit-filter','brightness(30)');
    $('div.edicion').removeClass('hidden');
  </script>
<script src="{!! asset('js/custom.js') !!}"></script>
<script src="{!! asset('js/image-picker.min.js') !!}"></script>
    <script>
        $("#logo_cupon").imagepicker()

        $('#visualizacion').css('visibility', 'visible');




        $('#visualizacion').click(function(){
            $('#titulo-cupon').html($('input:text[name=titulo]').val())
            $('#tipo-descuento').html($('#select_filtros option:selected').text());
            $('#imagen-cupon').html('<img src="{!! asset("img/cupones/'+$('select[name=logo]').val()+'") !!}" alt="">')
            $('#descripcion-cupon').html($('input:text[name=descripcion_corta]').val())
            $('#visualizacion-cupon').modal('show')
        })
    </script>
    <script src="{!! asset('js/image-picker.min.js') !!}"></script>
    <script>
        $("#logo_cupon").imagepicker()

        $("select[name=logo]").change(function(){
            $('#visualizacion').css('visibility', 'visible');
        });



        $('#visualizacion').click(function(){
            $('#titulo-cupon').html($('input:text[name=titulo]').val())
            $('#tipo-descuento').html($('#select_filtros option:selected').text());
            $('#imagen-cupon').html('<img src="{!! asset("img/cupones/'+$('select[name=logo]').val()+'") !!}" alt="">')
            $('#descripcion-cupon').html($('input:text[name=descripcion_corta]').val())
            $('#visualizacion-cupon').modal('show')
        })
    </script>
<script>
        $("#logo_cupon").imagepicker()
    </script>
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
        $(this).css('width', '100px');
        $(this).css('margin-top', '-12px');
    });

    $('input[name=categoria]:checked').parent('.radio-icon').css('width', '100px').css('margin-top', '-12px');


  </script>

    <script type="text/javascript">
        $('.subcategoria').css('display', 'none');
        $('input[name="categoria_id"]:checked').each(function() {
            var valor = this.value;
            $('.'+valor+'').css('display', 'inline-block');

        });
        $('.radio-icon').on('change', function(){
            $('input[name="subcategoria_id"]').each(function() {
                $('input[name="subcategoria_id"]').attr('value', '');
            });
            $('.subcategoria').css('display', 'none');

                $('input[name="categoria_id"]:checked').each(function() {
                var valor = this.value;
                $('.'+valor+'').css('display', 'inline-block');

            });
            $('input[name="subcategoria_id"]').on('click', function() {
                var subid = $(this).parent().attr('id');
                $('input[name="subcategoria_id"]').attr('value', subid);
            });
        });

    </script>
<script type="text/javascript">
    enable_fecha_fin();

    $('#ilimitado').on('click',enable_fecha_fin);

    function enable_fecha_fin() {
  
        if($('#ilimitado').prop('checked')){
            $("input[name='fecha_fin']").prop( "disabled", true );
        }else{
            $("input[name='fecha_fin']").prop("disabled",false);
        }
    }

</script>

@endsection
