@extends('layouts.app')

@section('content')

@section('CSSHeader')
<style type="text/css">
    #populares_categoria{
        clear: both;
    }
    /*.bloque{
        border:4px solid #121526;
        padding:0 10px ;
        margin: 10px auto;
    }*/
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection


<div id="content" class="container gestion">


<div class="row parent">
<h2>Home Desktop</h2>
{!! Form::open(['route' => 'bloque_desktop_cupon_principal'])!!}

    <div class="row">
        <div class="col-sm-4" style="margin-top: 30px;">

            {{ Form::radio('cupon_principal', 'select', is_null(@$data['desktop_cupon_principal']->cupon_id) ? false : true ) }} Cupón Seleccionado
        </div>

        <div class="col-sm-4" style="margin-top: 30px;">
            {{Form::radio('cupon_principal', 'fecha', is_null(@$data['desktop_cupon_principal']->fecha_corte_cupon) ? false : true ) }} Cupón por Fecha
        </div>

        <div class="col-sm-4" style="margin-top: 30px;">
            {{Form::radio('cupon_principal', 'random', is_null(@$data['desktop_cupon_principal']->cupon_id) && is_null(@$data['desktop_cupon_principal']->fecha_corte_cupon) ? true : false )}} Cupón Random
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" style="margin-top: 30px;">
            
            
            <div class="form-group">
                <select name="baner_principal" id="selec_banner_principal" style="width: 100%;">
                    <option value="" selected="" disabled="">Seleccione un cupón</option>
                    @foreach ($data['cupones'] as $cupon)
                        <option value="{!! $cupon->id !!}"> {!! $cupon->descripcion_corta !!}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 30px;">
                    @if (@$data['desktop_cupon_principal']->cupon)
                        @include('includes.cupon', ['cupon' => @$data['desktop_cupon_principal']->cupon])
                    @endif
                </div>
            </div>
            
        </div>

        <div class="col-sm-4" style="margin-top: 30px;">  
            {!! Form::text('fecha_cupon_home', @@$data['desktop_cupon_principal']->fecha_corte_cupon, ['id' => 'datepicker']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" style="margin-top: 30px;">  
            {!! Form::submit('Guardar Cupón Principal', ['class' => 'btn-blue']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
</div>
<!-- slider -->
    <div class="row parent" id="slide">
        <div class="col-xs-12 col-md-12 ">
            <h2>Home Móvil</h2>
        </div>
        <div class="col-md-4">
            <div class="bloques">
                <section class="container-fluid promos">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 section-title">
                            <p>Editor slider</p>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-xs-12  col-md-12">
                            <div class="bloque">
                                @foreach($data['bloques']->where('tipo', 'slide') as $slide)
                                    <div class="promo" data-id="sliders-{!! $slide->id!!}" id="slide-{!! $slide->id!!}">
                                        @include('includes.cupon', ['cupon' => $slide->cupon])
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="col-md-8 bloque-form hidden">
            <img class="cerrar" src="{!! asset('img/cerrar.png') !!}">
            <div class="submenu-comercio ">
                <ul class="submenu-item-list">
                    <a class="listado" href=""><li>EDITOR SLIDER</li></a>
                </ul>
                <p>Busca el cupón que quieres seleccionar por comercio, categoría o subcategoría.</p>
            </div>
            <div class="selectores">
                {!! Form::open(['route' => 'buscador-cupones-inicio', 'id' => 'form-buscador-inicio-slide'])!!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <select name="categoria" class="form-control" id="categorias_slide">
                        <option value="">Selecciona una categoria</option>
                        @foreach($data['categorias'] as $categoria)
                            <option name="categoria" value="{!!$categoria->id!!}">{!!$categoria->nombre!!}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <select id="subcategoria_slide" class="form-control" name="subcategoria">
                        <option value="">Selecciona una subcategoria</option>
                   </select>
                </div>

                <div class="form-group">
                    <select id="comercios" class="form-control" name="comercio">
                        <option value="">Cualquier comercio</option>
                        @foreach($data['comercios'] as $comercio)
                            <option name="comercio" value="{!!$comercio->id!!}">{!!$comercio->name!!}</option>
                        @endforeach
                   </select>
                </div>

                {!! Form::submit('Buscar', ['class' => 'btn-blue buscador_inicio', 'id' => 'submit_buscador_inicio_slide']) !!}
                {!! Form::close() !!}
            </div>

            <div class="tabla_resultados_busqueda" id="tabla_resultados_busqueda_slide">
            </div>
            <form id="editform-slide" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {!! Form::hidden('cupon_id','', array('class' => 'input-categorias', 'id' => 'cupon_id' )) !!}
                    {!! Form::submit('Guardar', ['class' => 'btn-blue editform' ]) !!}
                </div>
            </form> 

        </div>
    </div>
<!-- fin slider -->

<!-- 3 principales -->
    <div class="row parent" id="populares">
        <div class="col-md-4">
            <div class="bloques">
                <section class="container-fluid promos">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 section-title">
                            <p>Los más populares</p>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-xs-12  col-md-12">
                            <div class="bloque">
                                @foreach($data['bloques']->where('tipo', 'populares') as $popular)
                                    <div class="promo" data-id="popular-{!! $popular->id!!}" id="popular-{!! $popular->id!!}">
                                        @include('includes.cupon', ['cupon' => $popular->cupon])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-8 bloque-form hidden">
            <img class="cerrar" src="{!! asset('img/cerrar.png') !!}">
            <div class="submenu-comercio ">
                <ul class="submenu-item-list">
                    <a class="listado" href=""><li>EDITOR CUPONES MAS POPULARES</li></a>
                </ul>
                <p>Busca el cupón que quieres seleccionar por comercio, categoría o subcategoría.</p>
            </div>
            <div class="selectores">
                {!! Form::open(['route' => 'buscador-cupones-inicio', 'id' => 'form-buscador-inicio-populares'])!!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <select name="categoria" class="form-control" id="categorias_populares">
                        <option value="">Selecciona una categoria</option>
                        @foreach($data['categorias'] as $categoria)
                            <option name="categoria" value="{!!$categoria->id!!}">{!!$categoria->nombre!!}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <select id="subcategoria_populares" class="form-control" name="subcategoria">
                        <option value="">Selecciona una subcategoria</option>
                   </select>
                </div>

                <div class="form-group">
                    <select id="comercios" class="form-control" name="comercio">
                        <option value="">Cualquier comercio</option>
                        @foreach($data['comercios'] as $comercio)
                            <option name="comercio" value="{!!$comercio->id!!}">{!!$comercio->name!!}</option>
                        @endforeach
                   </select>
                </div>

                {!! Form::submit('Buscar', ['class' => 'btn-blue buscador_inicio', 'id' => 'submit_buscador_inicio_populares']) !!}
                {!! Form::close() !!}
            </div>

            <div class="tabla_resultados_busqueda" id="tabla_resultados_busqueda_populares">
            </div>
            <form id="editform-populares" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {!! Form::hidden('cupon_id','', array('class' => 'input-categorias', 'id' => 'cupon_id' )) !!}
                    {!! Form::submit('Guardar', ['class' => 'btn-blue editform' ]) !!}
                </div>
            </form> 

        </div>
    </div>
<!-- fin 3 principales -->
<!-- bloques -->

    @foreach($data['bloques']->where('tipo', 'bloque') as $bloque)
    <div class="row parent"  id="bloque-{!! $bloque->id!!}">
        <div class="col-md-4">
            <div class="bloques">
                {!! Form::open(['method' => 'DELETE', 'id' => 'borrar-bloque', 'action' => ['BloquesController@destroy', $bloque->id]]) !!}
                    <img class="eliminar hidden" src="{!! asset('img/cerrar.png') !!}" id="eliminar-bloque-{!! $bloque->id!!}" data-token="{{ csrf_token() }}" data-id="{!! $bloque->id!!}">
                {!! Form::close() !!}
                <section class="container-fluid promos">

                    <div class="row">
                        <div class="col-xs-12  col-md-12">
                            <div class='bloque'> 
                                <div class='promo' data-id="bloques-{!! $bloque->id!!}" data-cupon="portada">
                                    <a href="{!! url('categorias', $bloque->enlace) !!}" >

                                        <p style='font-size:25px;text-align:center;position:absolute;background:rgba(255,255,255,0.8);width:100%;top:60px;padding:20px;' id="titulo_portada" v-else> {!! str_replace('-', ' ', ucfirst($bloque->enlace))!!} </p>
                                        <img src="{!! asset($bloque->imagen) !!}">
                                    </a>
                                </div>
                                
                                <div class="promo promo_cupon" data-id="bloques-{!! $bloque->id!!}" data-cupon="cupon-1">
                                    @if($bloque->cupon_id != null)
                                        @include('includes.cupon', ['cupon' => $bloque->cupon->where('id', $bloque->cupon_id)->first()])
                                        @endif
                                </div>                           
                                <div class="promo promo_cupon" data-id="bloques-{!! $bloque->id!!}" data-cupon="cupon-2">
                                    @if($bloque->cupon_id2 != null)
                                        @include('includes.cupon', ['cupon' => $bloque->cupon->where('id', $bloque->cupon_id2)->first()])
                                    @endif
                                </div>                           
                            </div>

                        </div>
                    </div>
                </section>
            </div>
            
        </div>

        <div class="col-md-8 bloque-form hidden">
            <img class="cerrar" src="{!! asset('img/cerrar.png') !!}">
            <div class="submenu-comercio ">
                <ul class="submenu-item-list">
                    <a class="listado" href=""><li>EDITOR BLOQUES</li></a>
                </ul>
                <p>Busca el cupón que quieres seleccionar por comercio, categoría o subcategoría.</p>
            </div>
            <div class="selectores">
                {!! Form::open(['route' => 'buscador-cupones-inicio', 'id' => 'form-buscador-inicio-bloque-'.$bloque->id])!!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <select name="categoria" class="form-control" id="categorias_bloque-{!! $bloque->id !!}" >
                        <option value="">Selecciona una categoria</option>
                        @foreach($data['categorias'] as $categoria)
                            <option name="categoria" value="{!!$categoria->id!!}">{!!$categoria->nombre!!}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <select class="form-control" name="subcategoria" id="subcategoria_bloque-{!! $bloque->id !!}">
                        <option value="">Selecciona una subcategoria</option>
                   </select>
                </div>

                <div class="form-group">
                    <select id="comercios" class="form-control" name="comercio">
                        <option value="">Selecciona un comercio</option>
                        @foreach($data['comercios'] as $comercio)
                            <option name="comercio" value="{!!$comercio->id!!}">{!!$comercio->name!!}</option>
                        @endforeach
                   </select>
                </div>
                <a id="establecer-portada-bloque-{!! $bloque->id !!}" class="btn btn-blue ">Establecer portada</a>

                {!! Form::submit('Buscar', ['class' => 'btn-blue buscador_inicio', 'id' => 'submit_buscador_inicio_'.$bloque->id]) !!}
                {!! Form::close() !!}
            </div>

            <div class="tabla_resultados_busqueda" id="tabla_resultados_busqueda_bloque-{!! $bloque->id !!}"></div>

            <form id="editform-bloque-{!! $bloque->id !!}" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {!! Form::hidden('cupon_id','', array('class' => 'input-categorias' )) !!}
                    {!! Form::hidden('cupon_id2','', array('class' => 'input-categorias' )) !!}
                    <input type="hidden" name="cat_bloque" id="cat_bloque" ></input>
                    {!! Form::submit('Guardar', ['class' => 'btn-blue editform' ]) !!}
                </div>
            </form> 

        </div>
    </div>
    @endforeach
<!-- fin bloques -->

<!-- crear nuevo bloque -->
    <div class="row new_parent" id="">
        <div class="col-md-4">
            <a id="nuevo-bloque" class="btn btn-blue" style="display: block; margin: 0 auto;">Añadir nuevo bloque</a>
            <div class="bloques hidden">
                <section class="container-fluid promos">

                    <div class="row">
                        <div class="col-xs-12  col-md-12">
                            <div class='bloque' id="bloque-padre"> 
                                <div style="border: 2px solid #121424;height:168px;" class="promo"  data-cupon="portada" id="new_portada">
                                    <p style="text-align: center;padding-top: 23%;">Portada</p>
                                </div>
                                
                                <div style="border: 2px solid #121424;height:168px;" class="promo promo_cupon" data-cupon="nuevo_cupon-1" id="new_cupon1">
                                    <p style="text-align: center;padding-top: 23%;">Cupón 1</p>
                                </div>                           
                                <div style="border: 2px solid #121424;height:168px;" class="promo promo_cupon" data-cupon="nuevo_cupon-2" id="new_cupon2">
                                    <p style="text-align: center;padding-top: 23%;">Cupón 2</p>
                                </div>                           
                            </div>

                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-8 bloque-form hidden">
            <img class="cerrar" src="{!! asset('img/cerrar.png') !!}">
            <div class="submenu-comercio ">
                <ul class="submenu-item-list">
                    <a class="listado" href=""><li>EDITOR BLOQUES</li></a>
                </ul>
                <p>Busca el cupón que quieres seleccionar por comercio, categoría o subcategoría.</p>
            </div>
            <div class="selectores">
                {!! Form::open(['route' => 'buscador-cupones-inicio', 'id' => 'form-buscador-inicio'])!!}
                {!! csrf_field() !!}
                <div class="form-group">
                    <select name="categoria" class="form-control" id="categorias">
                        <option value="">Selecciona una categoria</option>
                        @foreach($data['categorias'] as $categoria)
                            <option name="categoria" value="{!!$categoria->id!!}">{!!$categoria->nombre!!}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <select class="form-control" name="subcategoria" id="subcategoria">
                        <option value="">Selecciona una subcategoria</option>
                   </select>
                </div>

                <div class="form-group">
                    <select id="comercios" class="form-control" name="comercio">
                        <option value="">Selecciona un comercio</option>
                        @foreach($data['comercios'] as $comercio)
                            <option name="comercio" value="{!!$comercio->id!!}">{!!$comercio->name!!}</option>
                        @endforeach
                   </select>
                </div>
                <a id="establecer-portada" class="btn btn-blue hidden">Establecer portada</a>
                {!! Form::submit('Buscar', ['class' => 'btn-blue', 'id' => 'submit_buscador_inicio']) !!}
                {!! Form::close() !!}
            </div>

            <div class="tabla_resultados_busqueda" id="tabla_resultados_busqueda"></div>

            <form id="newform" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {!! Form::hidden('primer_cupon','', array('class' => 'input-categorias', 'id' => 'primer_cupon' )) !!}
                    {!! Form::hidden('segundo_cupon','', array('class' => 'input-categorias', 'id' => 'segundo_cupon' )) !!}
                    {!! Form::hidden('cat_bloque','', array('class' => 'input-categorias', 'id' => 'cat-bloque' )) !!}
                    {!! Form::hidden('subcat_bloque','', array('class' => 'input-categorias', 'id' => 'subcat-bloque' )) !!}
                    {!! Form::submit('Guardar', ['class' => 'btn-blue editform' ]) !!}
                </div>
            </form> 

        </div>
    </div>
<!-- fin crear nuevo bloque -->



@endsection

@section('JSpage')

    <script src="{!! asset('js/vue.js') !!}"></script>
    {{--<script src="{!! asset('js/custom.js') !!}"></script>--}}

    <script type="text/javascript">
        $('.listado li').addClass('active');
        $('p.listado').removeClass('hidden');
    </script>

    <script type="text/javascript">
        var id_bloque;
        var buscador_inicio;
        var cupon;
        var cat_id;

        $('.bloques a').removeAttr('href');

        //añadimos estilos a los elementos seleccionados
        $('.promo').on('click', function(){
            $( '#tabla_resultados_busqueda_'+id_bloque ).empty();

            $('.bloque-form').addClass('hidden');
            $(this).parents('.parent').find('.bloque-form').removeClass('hidden');
            
            $('.promo').removeClass('borde_activa');
            $(this).addClass('borde_activa');
            $('.bloques').css('background', 'none');
            $('.bloques .eliminar').addClass('hidden');
            $(this).parents('.bloques').css('background-color', 'rgba(10, 21, 38, 0.3)');
            $(this).parents('.bloques').find('.eliminar').removeClass('hidden');
            $(this).parents('.bloques').find(".submenu-comercio").removeClass('hidden');

        });

        //cuando hagamos click sobre un cupon de inicio, sacamos el buscador de cupones
        $('.parent .promo').on('click', function(){
            id_bloque = $(this).parents('.parent').attr('id');
            cupon = $(this).parents('.parent').find('.borde_activa').data('cupon');   

            if(cupon == 'portada'){
                $('#establecer-portada-'+id_bloque).removeClass('hidden');
                $('.buscador_inicio').addClass('hidden');
            }else{
                $('#establecer-portada-'+id_bloque).addClass('hidden');
                $('.buscador_inicio').removeClass('hidden');

            }


           $('#establecer-portada-'+id_bloque).on('click', function(){
                categoria = $('#categorias_'+id_bloque).val();
                $('input[name="cat_bloque"]').attr('value', categoria);

                var cat_text = $('#categorias_'+id_bloque+' option[value="'+categoria+'"]').text();
                //console.log(cat_text);
                $('#titulo_portada').html(cat_text);
                //$('#editform-'+id_bloque).submit();
           }); 


            var id = $(this).data('id').substr(8);  
            $( '#tabla_resultados_busqueda_'+id_bloque ).empty();
            var url = window.location.href;
            $('#editform-'+id_bloque).attr('action', url+'/'+id);

            $('#categorias_'+id_bloque).on('change', function(e){
                var cat_id = e.target.value;
               
                $.get('{{ url('bloque') }}/create/ajax-cat?cat_id=' + cat_id, function(data) {
                    $('#subcategoria_'+id_bloque).empty();
                    $('#subcategoria_'+id_bloque).append('<option value="">Todas las subcategorías</option>');
                    $.each(data, function(index,subCatObj){
                        $('#subcategoria_'+id_bloque).append('<option value="'+subCatObj.id+'">'+subCatObj.nombre+'</option>');
                    });
                });
            });

            $('#eliminar-'+id_bloque).on('click', function(){

                if(confirm('¿Seguro que desea borrar este bloque?')){
                    $(this).parents('#borrar-bloque').submit();
                }
                /*var inputData = $(this).parents('#borrar-bloque').serialize();

                var dataId = $('#eliminar-'+id_bloque).attr('data-id');

                $.ajax({
                    url: '{{ url("/bloques") }}' + '/' + dataId,
                    type: 'POST',
                    data: inputData,
                    success: function( msg ) {
                        if ( msg.status === 'success' ) {

                        }
                    },
                    error: function( data ) {
                        if ( data.status === 422 ) {
                        }
                    }
                });

                return false;
*/
            });
        });

        //la hacer click en buscar, recuperamos todos los cupones por ajax y los mostramos
        $('.buscador_inicio').click(function(e){
            var url =  "{!! route('buscador-cupones-inicio') !!}";
            buscador_inicio = $("#form-buscador-inicio-"+id_bloque).serialize();
            $.post(url, buscador_inicio).done(function(result){
                $( '#tabla_resultados_busqueda_'+id_bloque ).html(result.tabla);
            }).fail(function (){
                alert('error');
            });

            e.preventDefault();
        });
        
        /*cuando seleccionamos un cupon, buscamos a qué hueco de la home pertenece, 
        y en función de eso insertamos los valores de los campos necesarios para actualizarlo
        */
        $(document).delegate(' .cupon', 'click', function(){
            cupon = $(this).parents('.parent').find('.borde_activa').data('cupon');   
            parent = $(this).parents('.parent').find('.borde_activa').attr('id');   

            $('#tabla_resultados_busqueda_'+id_bloque+' .promo').removeClass('borde_activa');

            $(this).addClass('borde_activa');

            if(cupon === 'cupon-1' || cupon == undefined){
                $('input[name="cupon_id"]').attr('value', $(this).attr('id'));

            }else if(cupon === 'cupon-2'){
                $('input[name="cupon_id2"]').attr('value', $(this).attr('id'));

            }else if(cupon == 'portada'){
                categoria = $('#categorias_'+id_bloque).val();
                $('input[name="cat_bloque"]').attr('value', $('#categorias_'+id_bloque).val());
            }
          
        });

        //vaciamos todos los elementos al darle a cerrar
        $('.cerrar').on('click', function(){
           $( '#tabla_resultados_busqueda_'+id_bloque ).empty();
           $('.bloque-form').addClass('hidden');
           $('.promo').removeClass('borde_activa');
           $('.bloques').css('background', 'none');
           $('.bloques .eliminar').addClass('hidden');
        });

    </script>

    <script type="text/javascript">
        var numerobloques = {!! $bloques !!};
        if(numerobloques == 9){
            $('#nuevo-bloque').addClass('hidden');
        }

        $('#nuevo-bloque').on('click', function(){

            $(this).parents('.new_parent').find('.bloques').removeClass('hidden');
            //$(this).parents('.new_parent').find('.bloque-form').removeClass('hidden');

            var id_nuevo = {!! max($data['bloques']->lists('id')->toArray()) !!}+1;
            //console.log(id_nuevo);
            
            //cuando hagamos click sobre un cupon de inicio, sacamos el buscador de cupones
            $('.new_parent .promo').on('click', function(){
               $(this).addClass('borde_activa');
               $(this).parents('.new_parent').find('.bloque-form').removeClass('hidden');
                $( '#tabla_resultados_busqueda' ).empty();
                var url = window.location.href+'/nuevo';
                $('#newform').attr('action', url);

                $('#categorias').on('change', function(e){
                    var cat_id = e.target.value;
                   
                    $.get('{{ url('bloque') }}/create/ajax-cat?cat_id=' + cat_id, function(data) {
                        $('#subcategoria').empty();
                        $('#subcategoria').append('<option value="">Todas las subcategorías</option>');
                        $.each(data, function(index,subCatObj){
                            $('#subcategoria').append('<option value="'+subCatObj.id+'">'+subCatObj.nombre+'</option>');
                        });
                    });
                });
                cupon = $(this).parents('.new_parent').find('.borde_activa').data('cupon');   
                if(cupon == 'portada'){
                    $('#establecer-portada').removeClass('hidden');
                    $('#submit_buscador_inicio').addClass('hidden');

                }else{
                     $('#establecer-portada').addClass('hidden');
                    $('#submit_buscador_inicio').removeClass('hidden');
                }
            });

        });



        $('#establecer-portada').on('click', function(){
           // console.log('portada button submitted');
            var cat_id = $('#categorias').val();
            var subcat_id = $('#subcategoria').val();
            if(subcat_id == ''){
                $('input[name="cat_bloque"]').attr('value', cat_id);
                var portada = $('#categorias option:selected').text();
            }else{
                $('input[name="subcat_bloque"]').attr('value', subcat_id);
                var portada = $('#subcategoria option:selected').text();
            }

            $('#new_portada p').html(portada);
        });

        /* PROBLEMA */

        $(document).delegate('.cupon', 'click', function(){
            $('#tabla_resultados_busqueda .promo').removeClass('borde_activa');

            $(this).addClass('borde_activa');
            parent = $(this).parents('.new_parent').find('#bloque-padre .borde_activa').attr('id');   
            if(parent === 'new_cupon1' ){
                $('input[name="primer_cupon"]').attr('value', $(this).attr('id'));
                $('#new_cupon1 p').html($(this).find('.cupon-titulo').html());

            }
            if(parent === 'new_cupon2' ){
                $('input[name="segundo_cupon"]').attr('value', $(this).attr('id'));
                $('#new_cupon2 p').html($(this).find('.cupon-titulo').html());

            }
        });
         
         //la hacer click en buscar, recuperamos todos los cupones por ajax y los mostramos
        $('#submit_buscador_inicio').click(function(e){

            var url =  "{!! route('buscador-cupones-inicio') !!}";
            buscador_inicio = $("#form-buscador-inicio").serialize();
            $.post(url, buscador_inicio).done(function(result){
                $( '#tabla_resultados_busqueda' ).html(result.tabla);
            }).fail(function (){
                alert('error');
            });

            e.preventDefault();
        });
    </script>

    <script type="text/javascript">
        $('.item').first().addClass('active');
        $('.item a').removeAttr('href');
        $('#carousel').on('click', function(){
          
        $('.slides').removeClass('item');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
  $('select').select2();
});
</script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd'
    });
  });
  </script>
@endsection

