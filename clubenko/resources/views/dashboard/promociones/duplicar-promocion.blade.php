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

    .ui-slider-range {
        background:green;
    }
    .percent {
        
        font-weight:bold;
        text-align:center;
        width:100%;
        border:none;
    }
    .bar.ui-slider.ui-slider-horizontal.ui-widget.ui-widget-content.ui-corner-all {
        height: 34px;
        border-radius: 0;
        background: transparent;
        border-bottom: 2px solid #fff;
        top: -34px;
    }
    p.porcentaje{
        position: absolute;
        z-index: 2;
        left: 72px;
        top: 32px;
    }
    p.percent {
        background: #121424;
        color: #fff;
        height: 34px;
        margin: 0;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#676a73+0,6e7774+50,676a73+50,676a73+50,676a73+50,676a73+50,676a73+50,0a1526+51,0a1523+100 */
        background: rgb(103,106,115); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(103,106,115,1) 0%, rgba(110,119,116,1) 50%, rgba(103,106,115,1) 50%, rgba(103,106,115,1) 50%, rgba(103,106,115,1) 50%, rgba(103,106,115,1) 50%, rgba(103,106,115,1) 50%, rgba(10,21,38,1) 51%, rgba(10,21,35,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(103,106,115,1) 0%,rgba(110,119,116,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(10,21,38,1) 51%,rgba(10,21,35,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(103,106,115,1) 0%,rgba(110,119,116,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(103,106,115,1) 50%,rgba(10,21,38,1) 51%,rgba(10,21,35,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#676a73', endColorstr='#0a1523',GradientType=0 ); /* IE6-9 */
        padding-top: 7px;
    }
    .ui-slider-range {
        background: #fff;
        border-radius: 0;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        border: none;
        background: none;
        font-weight: normal;
        color: none;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 16px 0 15px 40px;
        border-color: transparent transparent transparent #ffffff;
    }
    .ui-slider-horizontal .ui-slider-handle{
        top: 0;
        margin-left: -1px;
    }
    .ilimitado-box{
        font-weight: 400;
        color: #FFf;
        letter-spacing: 1px;
        margin-top: 30px;
    }

</style>
@endsection
<div class="container" id="duplicar-promocion">
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
                    <a class="listado" href="{!! route('listar-promociones', Auth::user()->slug) !!}"><li>LISTADO DE MIS PROMOCIONES</li></a>
                    <a class="creacion" href="{!! route('promociones.create') !!}"><li class="">NUEVA PROMOCIÓN</li></a>
                    <a class="edicion" href=""><li>EDITAR PROMOCIÓN</li></a>
                </ul>
                <div class="submenu-item-description">
                    <div class="edicion hidden">
                        <p>Edita tu Promoción si quieres modificarlo. También puedes editarlo o borrarlo.</p>   

                        <div class="enlaces">
                            <div class="editar"><a href="{!! route('promociones.edit', $data['promocion']->slug) !!}"><img src="{!! asset('img/editar.png') !!}"></a></div><div class="duplicar"><a href="{!! route('duplicar-promocion', $data['promocion']->slug) !!}"><img src="{!! asset('img/duplicar.png') !!}"></a></div><div class="borrar"> <a href="{!! route('borrar-promocion', $data['promocion']->slug) !!}"><img src="{!! asset('img/eliminar.png') !!}"></a></div>
                          
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gris-medio">
        <div class="col-md-4 col-md-offset-4">
            <div class="promo">
                @include('includes.promocion', ['promocion' => $data['promocion']])
            </div>
        </div>
    </div>
    <!-- Fin submenu comercio -->
    <!-- Formulario -->
   {!! Form::open([
        'method' => 'POST',
        'route' => ['duplicar-promocion', $data['promocion']->slug],
        'files' => true
    ]) !!}   
    <div class="row gris-oscuro">
        <div class="col-md-12">

            <p>Selecciona la categoría donde aparecerá tu Promoción</p>
            <div class="form-group categorias">
                @foreach($data['categorias'] as $categoria)
      
                        <div class="radio-box">
                            <label class="radio-icon">
                                <img src="{!! asset($categoria->imagen)!!}">
                                <input class="input-img" data-categoria_slug="{!! $categoria->slug !!}" type="radio" name="categoria_id" value="{!! $categoria->id !!}" @if($categoria->id == $data['promocion']->categoria_id) checked="true" @endif/>
                            </label>
                            <p>{!! $categoria->nombre !!}</p>
                        </div>
                
                @endforeach
            </div>        

            <p>Selecciona la subcategoría donde aparecerá tu Promoción</p>
            <div class="form-group">
                <div class="radio-subcategorias"  id="radio-subcategorias">
                    @foreach($data['subcategorias'] as $subcategoria)
                    <div class=" subcategoria {!! $subcategoria->categoria_id !!}" id="{!! $subcategoria->id !!}">
                        <input type="radio" name="subcategoria_id" value="{!! $subcategoria->id !!}" class="subcategoria" id="subcat{!! $subcategoria->id !!}" @if($subcategoria->id == $data['promocion']->subcategoria_id) checked="true" @endif></input>
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
            {{--!! Form::date('fecha_inicio', $data['promocion']->fecha_inicio, array('class', 'form-control hasDatepicker') !!--}}
            <input id="fecha_inicio" class="form-control" name="fecha_inicio" type="date" value="{!! $data['promocion']->fecha_inicio !!}" placeholder="{!! $data['promocion']->fecha_inicio !!}">
        </div>

        <div class="fecha form-group col-md-5">
            {!! Form::label('fecha_fin', 'Fecha de fin', array('class', 'control-label')) !!}
            <input id="fecha_fin" class="form-control hasDatepicker" name="fecha_fin" type="date"value="{!! $data['promocion']->fecha_fin !!}" placeholder="{!! ($data['promocion']->fecha_fin != '9999-12-31')?$data['promocion']->fecha_fin : ''  !!}">                        
        </div>

        <div class="fecha form-group col-md-2 ilimitado-box">
            <input type="checkbox" name="ilimitado" id='ilimitado' {!! ($data['promocion']->fecha_fin == '9999-12-31')?'checked' : '' !!}> Ilimitado                        
        </div>
            
    </div>
    <div class="row gris-medio">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                {!! Form::label('titulo', 'Título del Promoción', array('class', 'control-label')) !!}
                {!! Form::text('titulo', $data['promocion']->titulo , array('class' => 'form-control')) !!}
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
        <div class="col-md-4">
            {!! Form::label('precio', 'Precio de la promoción') !!}
            {!! Form::number('precio', $data['promocion']->precio , array('class' => 'form-control','id'=>'precio','step'=>'any')) !!}
        </div>

        <div class="project col-md-4" id="bar">
            {!! Form::label('filtro_id', 'Aplica un descuento') !!}
            <div class="text-center">
            <p class="porcentaje">@{{message}}</p>
                <p class="percent"></p>
                <input type="hidden" class="percent" name="filtro_id" v-model="message" id="porcentaje" value="{!! $data['promocion']->filtro_id !!}"/>
            </div>
            <div class="bar"></div>
        </div>

        <div class="project col-md-3 col-md-offset-1" id="bar">
            {!! Form::label('precio_descuento', 'Precio con descuento') !!}
            {!! Form::text('precio_descuento', $data['promocion']->precio_descuento , array('class' => 'form-control','id'=>'precio_descuento','readonly')) !!}
        </div>

    </div>

    <div class="row gris-medio">       
        <div class="col-md-4">
            {!! Form::label('tipo_promocion', 'Selecciona el tipo de promoción : ') !!}
        </div>
        <div class="col-md-4 form-group radio-select-text">
            {!! Form::radio('tipo_promocion','pago',[(!$data['promocion']->reserva)?'checked':''] ) !!} Pago
        </div>
        <div class="col-md-4 form-group radio-select-text">
            {!! Form::radio('tipo_promocion','reserva',[($data['promocion']->reserva)?'checked':'']) !!} Reserva
        </div>
    </div>

    <div class="row gris-medio">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('descripcion_corta', 'Descripción breve', array('class', 'control-label')) !!}
                {!! Form::text('descripcion_corta', $data['promocion']->descripcion_corta , array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="row gris-medio">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('descripcion', 'Descripción completa de la oferta', array('class', 'control-label')) !!}
                {!! Form::textarea('descripcion', $data['promocion']->descripcion , array('class' => 'form-control',  'placeholder' => 'Descripción')) !!}
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
                    {!! Form::label('condiciones', 'Condiciones de la Promoción', array('class', 'control-label')) !!}
                    {!! Form::textarea('condiciones', $data['promocion']->condiciones , array('class' => 'form-control',  'placeholder' => 'Condiciones')) !!}
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
            {!! Form::submit('Duplicar Promoción', array('class' => 'btn-blue'))!!}
            <p class="delete-title">Duplicar la Promoción. Recuerda que podrás ver todos los promociones en la sección de listado de mis promociones.</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('JSpage')
    <script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>
    
    <script src="{!! asset('js/vue.js') !!}"></script>
    <script type="text/javascript">
        new Vue({
          el: '#bar',
          data: {
            message: '{!! $data['promocion']->filtro->nombre!!}',
            
          }
        });
    </script>

    {{-- Incluimos JS para la carga dinámica de las imágenes --}}
    @include('dashboard.includes.js')

    <script type="text/javascript">
        var $tiendas_promocion = $(".js-example-basic-multiple").select2();
        $tiendas_promocion.val(
            [@foreach($data['promocion']->tienda as $tienda)
                "{{$tienda->id}}",
             @endforeach]
            ).trigger("change");
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
        $("#logo_promocion").imagepicker()

        $('#visualizacion').css('visibility', 'visible');




        $('#visualizacion').click(function(){
            $('#titulo-promocion').html($('input:text[name=titulo]').val())
            $('#tipo-descuento').html($('#select_filtros option:selected').text());
            $('#imagen-promocion').html('<img src="{!! asset("img/promociones/'+$('select[name=logo]').val()+'") !!}" alt="">')
            $('#descripcion-promocion').html($('input:text[name=descripcion_corta]').val())
            $('#visualizacion-promocion').modal('show')
        })
    </script>
    <script src="{!! asset('js/image-picker.min.js') !!}"></script>
    <script>
        $("#logo_promocion").imagepicker()

        $("select[name=logo]").change(function(){
            $('#visualizacion').css('visibility', 'visible');
        });



        $('#visualizacion').click(function(){
            $('#titulo-promocion').html($('input:text[name=titulo]').val())
            $('#tipo-descuento').html($('#select_filtros option:selected').text());
            $('#imagen-promocion').html('<img src="{!! asset("img/promociones/'+$('select[name=logo]').val()+'") !!}" alt="">')
            $('#descripcion-promocion').html($('input:text[name=descripcion_corta]').val())
            $('#visualizacion-promocion').modal('show')
        })
    </script>
<script>
        $("#logo_promocion").imagepicker()
    </script>
    <script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>
    
    <script type="text/javascript">
        

    var $tiendas_promocion = $(".js-example-basic-multiple").select2();
    $tiendas_promocion.val(
            [@foreach($data['promocion']->tienda as $tienda)
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

    $('input[name=categoria_id]:checked').parent('.radio-icon').css('width', '100px').css('margin-top', '-12px');


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
                $('input[name="subcategoria"]').attr('value', subid);
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

<script type="text/javascript">

    var valor_filtro = "{!! $data['promocion']->filtro_id !!}";

    if(valor_filtro > 2){
        $('#bar').find('p.porcentaje').css({'color': '#121424'}).html(valor_filtro*5-5+'%');
    }

    $(function() {
      $('.project').each(function() {
        var $projectBar = $(this).find('.bar');
        var $projectPercent = $(this).find('input.percent');
        var $textPercent = $(this).find('p.porcentaje');
        var $projectRange = $(this).find('.ui-slider-range');
        $projectBar.slider({
          range: "min",
          animate: true,
          value: valor_filtro,
          min: 1,
          max: 21,
          step: 1,
          slide: function(event, ui) {
            $projectPercent.val(ui.value);
            $textPercent.html(ui.value*5-5+'%');
            var percent = ui.value;
            if (percent > 2) {
              $textPercent.css({
                'color': '#121424'
              });
            }else{
              $textPercent.css({
                'color': '#fff'
              });
            }

            var precio = $('input[name="precio"]').val();

            precio = precio.replace(",", ".");

            precio_calculado = precio-(((ui.value*5-5)*precio)/100);
            precio_calculado = (Math.round(precio_calculado*100))/100
            $('#precio_descuento').val(precio_calculado);
          },
        });

    
        $('.ui-slider-range').css('width', $projectPercent.val());
        if($projectPercent.val() > '10%'){
            $textPercent.css({
                'color': '#121424'
         });
        }
        $('span.ui-slider-handle.ui-state-default.ui-corner-all').css('left',$projectPercent.val());
      });
    });
</script>

@endsection
