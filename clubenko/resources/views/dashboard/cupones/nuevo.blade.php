@extends('layouts.app')


@section('CSSHeader')

@endsection

@section('content')

    {!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}
     {!! Html::style(asset('css/image-picker.css') ) !!}

<style type="text/css">
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

    #bar{
        display: none;
    }

    .ilimitado-box{
        font-weight: 400;
        color: #FFf;
        letter-spacing: 1px;
        margin-top: 30px;
    }
</style>


<div id="" class="container">
    @include('includes.submenu-comercio')

    @if(Auth::user()->tienda()->where('confirmado', 1)->first() == '')
    <div class="row">
        <div class="col-md-12">
            <div class="blanco">
                <p>Aún no tiene ninguna tienda registrada a la que poder asignar un cupón. Por favor, registre una tienda antes de crear nuevos cupones.</p>
            </div>
        </div>
    </div>
    @else
        {!! Form::open([
            'method' => 'POST',
            'route' => 'cupones.store',
            'files' => true
        ]) !!}   
        <div class="row gris-oscuro">
            <div class="col-md-12">

                <p>Selecciona la categoría donde aparecerá tu cupón</p>
                <div class="form-group categorias">
                    @foreach($data['categorias'] as $categoria)
                    <div class="radio-box {!! (old('categoria_id') == $categoria->id) ? 'radio-box-active' : '' !!}">
                        <label class="radio-icon">
                            <img src="{!! asset($categoria->imagen)!!}">
                            <input class="input-img" data-categoria_slug="{!! $categoria->slug !!}" type="radio"  name="categoria_id" value="{!! $categoria->id !!}" {!! (old('categoria_id') == $categoria->id) ? 'checked' : '' !!}></input>
                        </label>
                        <p>{!! $categoria->nombre !!}</p>
                    </div>
                    @endforeach
                </div>

                <p>Selecciona la subcategoría donde aparecerá tu cupón</p>
                <div class="form-group">
                    <div class="radio-subcategorias" id="radio-subcategorias">
                         @foreach($data['subcategorias'] as $subcategoria)
                         <div class="hidden subcategoria {!! $subcategoria->categoria_id !!} ">
                            <input type="radio" name="subcategoria_id" value="{!! $subcategoria->id !!}" class="subcategoria" id="subcat{!! $subcategoria->id !!}" {!! (old('subcategoria_id') == $subcategoria->id) ? 'checked' : '' !!}></input>
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
        <div class="row gris-oscuro">
            <div class="col-md-12">
                <p class="titulo">Seleccione la tienda o locales donde se puede hacer uso del cupón</p>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="blanco">
                    <div class="form-group">
                        <select name="tienda[]" class="form-control js-example-basic-multiple" id="id_label_multiple" multiple="multiple" >

                            @foreach($data['tiendas'] as $tienda)
                                <option value="{!! $tienda->id !!}" {!! (!is_null(old("tienda")) && in_array($tienda->id,old("tienda")))? "selected":""!!} >{{$tienda->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gris-medio">
            <div class="fecha form-group col-md-5">
                {!! Form::label('fecha_inicio', 'Fecha de inicio', array('class', 'control-label')) !!}
                {!! Form::date('fecha_inicio','',['id'=>'fecha_inicio','class'=>'form-control hasDatepicker']) !!}
            </div>

            <div class="fecha form-group col-md-5">
                {!! Form::label('fecha_fin', 'Fecha de fin', array('class', 'control-label')) !!}
                {!! Form::date('fecha_fin','',['id'=>'fecha_fin','class'=>'form-control hasDatepicker']) !!}                        
            </div>

            <div class="fecha form-group col-md-2 ilimitado-box">
                <input type="checkbox" name="ilimitado" id='ilimitado' {!! (old('ilimitado')?'checked':'') !!}> Ilimitado                        
            </div>

        </div>
        <div class="row gris-medio">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                    {!! Form::label('titulo', 'Título del cupón', array('class', 'control-label')) !!}
                    {!! Form::text('titulo', '' , array('class' => 'form-control')) !!}
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
            <div class="col-md-6">
                {!! Form::label('tipo_descuento', 'Tipo de descuento') !!}
                <div class="filtro-select">
                    <select name="tipo_descuento" class="" id="tipo_descuento">
                        <option name="tipo_descuento" value="1" {!! old("tipo_descuento") == 1 ? "selected":""!!}>2x1</option>
                        <option name="tipo_descuento" value="2" {!! old("tipo_descuento") == 2 ? "selected":""!!}>Porcentaje de descuento</option>
                    </select>
                </div>
            </div>

            <div class="project col-md-6" id="bar">
                {!! Form::label('filtro', 'Desliza para seleccionar el porcentaje de descuento') !!}
                <div class="text-center">
                <p class="porcentaje">0%</p>
                    <p class="percent"></p>
                    <input type="hidden" class="percent" name="filtro" v-model="message" id="porcentaje" value="{!! old('filtro') !!}" />
                </div>
                <div class="bar"></div>
            </div>
        </div>

        <div class="row gris-medio">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('descripcion_corta', 'Descripción breve', array('class', 'control-label')) !!}
                    {!! Form::text('descripcion_corta', '' , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row gris-medio">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('descripcion', 'Descripción completa de la oferta', array('class', 'control-label')) !!}
                    {!! Form::textarea('descripcion', '' , array('class' => 'form-control',  'placeholder' => 'Descripción')) !!}
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
                    {!! Form::textarea('condiciones', '' , array('class' => 'form-control',  'placeholder' => 'Condiciones')) !!}
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

        <div class="row botones">
            <div class="col-md-12">
                <div class="blanco">
                    @if (count($errors) > 0)
                        <div class="alert alert-success">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {!! Form::submit('Crear cupón', array('class' => 'btn-blue'))!!}
                    <a id="visualizacion" class="btn-grey" style="visibility: hidden">Visualizar</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}


    @include('cupones.include.visualizar-cupon')

    </div>

@endif

@endsection

@section('JSpage')
    {{--<script src="{!! asset('js/custom.js') !!}"></script>--}}
    
    {{-- Incluimos JS para la carga dinámica de las imágenes --}}
    @include('dashboard.includes.js')

    <script type="text/javascript">
        //recogemos el valor antiguo del input name=catergoria_id
        var old_categoria_id = "{!! old('categoria_id') !!}";
    </script>

    {{-- si hay un error mostramos los elementos seleccionados del formulario --}}
    @if (count($errors) > 0)
        <script type="text/javascript">
            //abrimos la subcategoria de la cartegoria seleccionada
            $('.'+old_categoria_id).removeClass('hidden').css('display', 'inline-block');
            
            if($('#tipo_descuento').val() == 2){
                //mostramos la bar de % si elegimos el segundo tipo de descuento
                $('#bar').css({'display':'block'});
            }
        </script>
    @endif

    <script src="{!! asset('js/image-picker.min.js') !!}"></script>
    <script>
        $("#logo_cupon").imagepicker()

        $(".input-img").change(function(){
            $('#visualizacion').css('visibility', 'visible');
        });

        $('#visualizacion').click(function(){
            $('#titulo-cupon').html($('input:text[name=titulo]').val())
            $('#tipo-descuento').html($('#select_filtros option:selected').text());
            console.log($('#select_filtros option:selected').text())
            $('#imagen-cupon').html('<img src="{!! asset("img/cupones/'+$('select[name=logo]').val()+'") !!}" alt="">')
            $('#descripcion-cupon').html($('input:text[name=descripcion_corta]').val())
            $('#visualizacion-cupon').modal('show')
        })
    </script>

    <script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>
    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>

    <script type="text/javascript">

        $('.radio-icon').on('click', function(){
            $('.radio-box').removeClass('radio-box-active');
            $(this).parent('.radio-box').addClass('radio-box-active');
        });

        $('.creacion li').addClass('active');
        $('p.creacion').removeClass('hidden').css('margin-top', '50px');
    </script>


    <script type="text/javascript">

        $('.radio-icon').on('change', function(){
            $('.subcategoria').css('display', 'none');
            $('.subcategoria').prop('checked', false);

            $('input[name="categoria_id"]:checked').each(function() {
                var valor = this.value;
                $('.'+valor+'').css('display', 'inline-block').removeClass('hidden');

            });
        });

    </script>

    <script type="text/javascript">
        //recorgemos el valor antiguo del input name=filtro
        var old_filtro = "{!! old('filtro') !!}";

        if(old_filtro > 2){
            //dibujamos el %, elegido en la bara de %
            $('#bar').find('p.porcentaje').css({'color': '#121424'}).html(old_filtro*5-5+'%');
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
              value: old_filtro,
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
              },
            });
          });
        });

    </script>

    <script type="text/javascript">
        //mosatramos la barra de procentages solo cuando elegimos el tipo de descuento correspondiente
        $('#tipo_descuento').change(function(){
            if($(this).val() == 2){
                $('#bar').css({'display':'block'})
            }else{
                $('#bar').css({'display':'none'})
            }

        })
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