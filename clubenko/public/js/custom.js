/*$('.bloques a').removeAttr('href');
$('.promo').on('click', function(){
    $('.promo').css('border', 'none');
    $(this).css('border', '8px solid #121526');
    $('.bloques').css('background', 'none');
    $(this).parents('.bloques').css('background-color', 'rgba(10, 21, 38, 0.3)');
    //$('.submenu-comercio').addClass('hidden');
    $(this).parents('.bloques').find(".submenu-comercio").removeClass('hidden');

});
$('select[name=texto]').on('change', function(){

  var valor = $('select[name=texto]').val();
  $('select[name=enlace]').attr('value', valor);
  //alert($('select[name=enlace]').val());
});


$('#populares .promo').on('click', function(){
  $('.bloque-form').addClass('hidden');
  $('#populares .bloque-form').removeClass('hidden');
});


$('.promo').on('click', function(){
  $( '#tabla_resultados_busqueda' ).empty();

  $('.bloque-form').addClass('hidden');
  $(this).parents('.parent').find('.bloque-form').removeClass('hidden');
});


$('.cerrar').on('click', function(){
  $( '#tabla_resultados_busqueda' ).empty();
  $('.bloque-form').addClass('hidden');
   $('.promo').css('border', 'none');
   $('.bloques').css('background', 'none');
});
*/

    $('.listado li').addClass('active');
    $('p.listado').removeClass('hidden');
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
            }else{
                $('#establecer-portada-'+id_bloque).addClass('hidden');

            }


           $('#establecer-portada-'+id_bloque).on('click', function(){
                categoria = $('#categorias_'+id_bloque).val();
                $('input[name="cat_bloque"]').attr('value', categoria);

                var cat_text = $('#categorias_'+id_bloque+' option[value="'+categoria+'"]').text();
                console.log(cat_text);
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
                //confirm('¿Seguro que desea borrar este bloque?');
                $(this).parents('#borrar-bloque').submit();
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

            $('#tabla_resultados_busqueda_'+id_bloque+' .promo').removeClass('borde_activa');

            $(this).addClass('borde_activa');

            if(cupon == 'cupon-1' || cupon == undefined){
                $('input[name="cupon_id"]').attr('value', $(this).attr('id'));

            }else if(cupon == 'cupon-2'){
                $('input[name="cupon_id2"]').attr('value', $(this).attr('id'));

            }else if(cupon == 'portada'){
                categoria = $('#categorias_'+id_bloque).val();
                console.log(categoria);
                $('input[name="cat_bloque"]').attr('value', $('#categorias_'+id_bloque).val());
                console.log($('input[name="cat_bloque"]').val());
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
var numerobloques = {!! $data['bloques'] !!};
        if(numerobloques.length == 12){
            $('#nuevo-bloque').addClass('hidden');
        }

        $('#nuevo-bloque').on('click', function(){

            $(this).parents('.new_parent').find('.bloques').removeClass('hidden');
            //$(this).parents('.new_parent').find('.bloque-form').removeClass('hidden');

            var id_nuevo = {!! max($data['bloques']->lists('id')->toArray()) !!}+1;
            console.log(id_nuevo);
            
            //cuando hagamos click sobre un cupon de inicio, sacamos el buscador de cupones
            $('.new_parent .promo').on('click', function(){
               $(this).addClass('borde_activa');
               $(this).parents('.new_parent').find('.bloque-form').removeClass('hidden');
                $( '#tabla_resultados_busqueda' ).empty();
                var url = window.location.href+'/nuevo';
                console.log(url);
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
                }else{
                     $('#establecer-portada').addClass('hidden');
                }
            });

        });



        $('#establecer-portada').on('click', function(){
            console.log('portada button submitted');
            var cat_id = $('#categorias').val();
            var subcat_id = $('#subcategoria').val();
            if(subcat_id == ''){
                $('input[name="cat_bloque"]').attr('value', cat_id);
            }else{
                $('input[name="subcat_bloque"]').attr('value', subcat_id);
            }
            console.log('categoria = '+cat_id+' - subcategoria = '+subcat_id);
        });

        $(document).delegate('.cupon', 'click', function(){
            $('#tabla_resultados_busqueda .promo').removeClass('borde_activa');

            $(this).addClass('borde_activa');
            cupon = $(this).parents('.new_parent').find('.borde_activa').data('cupon');   
            console.log(cupon);

            if(cupon == 'cupon-1' || cupon == undefined){
                $('input[name="cupon_id"]').attr('value', $(this).attr('id'));

            }
            if(cupon == 'cupon-2'){
                console.log( $(this).attr('id'));


                $('#id_cupon2').attr('value', $(this).attr('id'));

            }
        });
         
         //al hacer click en buscar, recuperamos todos los cupones por ajax y los mostramos
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