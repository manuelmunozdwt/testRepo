@extends('layouts.app');    

@section('CSSHeader')
<link rel="stylesheet" href="{!! asset('css/croppie/croppie.css') !!} " />
{!! Html::style(asset('plugins/bootstrap-select2/select2.min.css') ) !!}

<style type="text/css">
    .caducado{
        width: 92%;
        height: 203px;
    }
    .datos-descuento{
        width: 72%;
        height: 70px;
        float: left;
    }
    .upload-demo-wrap{
        height: 450px;
    }
    .ezdz-dropzone img{
        height: 200px;
        width: auto;
    }
    
</style>
@endsection

@section('content')

    <div id="content" class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>  
        <div class="row" id="ges-categorias">
            <div class="col-md-4">
                <div class="submenu-comercio">
                    <ul class="submenu-item-list submenu-categorias">
                        <a class="listado" href="{!! route('categorias.create') !!}"><li>TODAS LAS CATEGORÍAS</li></a>
                        <a class="creacion" href=""><li class=""></li></a>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="submenu-comercio submenu-item-description">
                    @foreach($data['categorias']->chunk(4) as $chunk)
                    <div class="row">
                        @foreach($chunk as $categoria)
                        <div class="col-md-3">
                            <a role="button"  data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <div class="categoria-box" data-slug="{{ $categoria->slug }}" data-id="{{ $categoria->id }}">
                                    <img src="{!! asset($categoria->imagen) !!}">
                                    <p>{!! $categoria->nombre !!}</p>
                                    <p><a href="{!! route('ver-subcategorias', $categoria->slug) !!}">(<span class="subcat">{!! count($categoria->subcategoria->where('confirmado', 1)) !!}</span>)</a></p>
                                    <p class="hidden">{!! count($categoria->cupon) !!}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="collapse" id="collapseExample">
                        {!! Form::open(['id' => 'editform', 'files' >= true]) !!}
                            <div class="row" style="margin-bottom: 20px;">

                            
                                <input type="hidden" id="imagen" name="imagen" required="">
                                <input type="hidden" id="categoria_id" name="categoria_id">
                            
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select style="width: 100%" name="cupon_superior">
                                                <option value="" disabled="" selected="">Seleccione un cupón</option>
                                                @foreach ($data['cupones'] as $cupon)
                                                    <option value="{!! $cupon->id !!}">{!! $cupon->titulo !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="cupon_superior"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select style="width: 100%" name="cupon_inferior">
                                                <option value="" disabled="" selected="">Seleccione un cupón</option>
                                                @foreach ($data['cupones'] as $cupon)
                                                    <option value="{!! $cupon->id !!}">{!! $cupon->titulo !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="cupon_inferior"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="upload-demo" style="margin-bottom: 30px; ">
                                <div class="row">
                                    <div class="actions">
                                        <div class="form-group" id="cambiar-foto">
                                            <input type="file" id="upload" value="Choose a file" accept="image/*" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row botones-usuario">
                                    <a class="gris editar">Ajuste el banner</a>
                                </div>  
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="upload-demo-wrap">
                                            <div id="upload-demo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre banner</label>
                                {{Form::text('nombre', '', ['id' => 'banner_nombre', 'class' => 'form-control', 'placeholder' => 'Introduce el nombre del banner'])}}
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Alt banner</label>
                                {{Form::text('alt', '', ['id' => 'banner_alt', 'class' => 'form-control', 'placeholder' => 'Introduce el alt del banner'])}}
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Enlace banner</label>
                                {{Form::text('enlace', '', ['id' => 'banner_enlace', 'class' => 'form-control', 'placeholder' => 'Introduce el enlace del banner'])}}
                            </div>

                            <button type="button" class="btn-blue" id="send_form">Guardar</button>
                                    
                            
                        </form>
                        
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
                </div>
                <div class=" blue">
                    <p class="subcat"></p>
                    <p class="cup"></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('JSpage')
    <script type="text/javascript">
        $('.listado li').addClass('active');

        $('.categoria-box').on('mouseover', function(){
            var subcat = $(this).find('.subcat').text();
            var cupon  = $(this).find('.hidden').text();
            $('.blue .subcat').text('Esta categoría tiene '+subcat+' subcategorias.');
            $('.blue .cup').text('Hay un total de '+cupon + ' cupones.');
        });
    </script>
    <script type="text/javascript">

        $('.categoria-box').on('click', function(){
            var categoria_id = $(this).data('id');
            $('#categoria_id').val(categoria_id);
        $.ajax({
            url: '{!! route('custom_categorias_data') !!}',
            type: 'POST',
            data: {categoria_id: categoria_id},
        })
            .done(function(result) {
                console.log(result);
                if (result.cupon_inf != null){
                    $('#cupon_inferior').html(result.cupon_inf)
                }
                else{
                    $('#cupon_inferior').html('')
                }
                if (result.cupon_sup != null){
                    $('#cupon_superior').html(result.cupon_sup)
                }
                else{
                    $('#cupon_superior').html('')
                }

                if (result.banner_nombre != null){
                    $('#banner_nombre').val(result.banner_nombre)
                }
                else{
                    $('#banner_nombre').val('')
                }

                if (result.banner_alt != null){
                    $('#banner_alt').val(result.banner_alt)
                }
                else{
                    $('#banner_alt').val('')
                }

                if (result.banner_enlace != null){
                    $('#banner_enlace').val(result.banner_enlace)
                }
                else{
                    $('#banner_enlace').val('')
                }

                if (result.banner_categoria != ''){
                    $('.ezdz-dropzone img').attr('src', '{!! asset('') !!}'+ result.banner_categoria);
                }
                else{
                    $('.ezdz-dropzone img').attr('src', '{!! asset('img/arrastre-imagen.png')!!}');
                }
     
        });
        

        });
    </script>


    <script src="{!! asset('js/croppie/croppie.js') !!}"></script>

<script>


    function upload() {
        var $uploadCrop;

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 245,
                height: 415
            },
            enableExif: true
        });

        //Detectamos la imagen y la pasamos al crop
        $('#upload').on('change', function () { readFile(this); });

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                    
                }
                
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }


        $('#send_form').on('click', function (ev) {

            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $('#imagen').val(resp);
                $('#editform').submit();
            });
        });
        
    }

function init() {
        upload();
    }

$(document).ready(function(){
    init()
});
</script>

<script type="text/javascript">
    $('#upload').ezdz({
      text: "<img src={!! asset('img/arrastre-imagen.png')!!} style='height:100%'>",
    });
</script>

<script src="{!! asset('plugins/bootstrap-select2/select2.min.js') !!}"></script>
<script>
    $("select").select2();
</script>

@endsection

