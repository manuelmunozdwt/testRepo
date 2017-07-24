@extends('layouts.app')

@section('CSSHeader')
<link rel="Stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.css" />
<link rel="stylesheet" href="{!! asset('css/croppie/croppie.css') !!} " />
@endsection

@section('content')

<div class="container" id="mi-cuenta">
    
    <div class="row">

        <div class="col-sm-6">
        
            <div class="row botones-usuario">
                <div class="col-sm-12">
                    <a class="gris editar">Sugerimos que subas una imagen de 250px X 238px</a>
                </div>
                
            </div>  
            <div class="upload-demo" id="upload-demo-uno" style="margin-bottom: 30px; ">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="actions">
                            <div class="form-group" id="cambiar-foto">
                                <input type="file" id="upload-izq" value="Choose a file" accept="image/*" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row botones-usuario">
                    <div class="col-sm-12">
                        <a class="gris editar">Ajuste el banner</a>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12">
                        <div class="upload-demo-wrap">
                            <div class="upload-demo-id-uno"></div>
                        </div>
                    </div>
                </div>
            </div>


            {!! Form::open(['route' => 'banners_menu_edit', 'files' => true, 'id' => 'form_banner_menu_uno']) !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="hidden" id="imagen" name="imagen" required="">
                        <input type="hidden" name="banner_menu" value='1' required="">
                    </div>
                </div>
            </div>


            <div class="row editar">
                
                <div class="col-sm-12">
                    <div class="datos-usuario">

                        <div class="form-group{{ $errors->has('enlace') ? ' has-error' : '' }}">
                            {!! Form::text('enlace', @$data['banners_menu']->enlace, array('class' => 'form-control',  'placeholder' => 'Enlace banner HTTP://')) !!}
                            <div class="col-md-6">
                                @if ($errors->has('enlace'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('enlace') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row submit">
                <div class="col-md-12">
                    <button type="buttom" class="submit-datos" id="send_form">Guardar cambios</button>
                </div>
            </div>
            
            {!! Form::close() !!}
            
        </div>


        <div class="col-sm-6">
        
            <div class="row botones-usuario">
                <div class="col-sm-12">
                    <a class="gris editar">Sugerimos que subas una imagen de 250px X 238px</a>
                </div>
                
            </div>  
            <div class="upload-demo" id="upload-demo-dos" style="margin-bottom: 30px; ">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="actions">
                            <div class="form-group" id="cambiar-foto">
                                <input type="file" id="upload-der" value="Choose a file" accept="image/*" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row botones-usuario">
                    <div class="col-sm-12">
                        <a class="gris editar">Ajuste el banner</a>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12">
                        <div class="upload-demo-wrap">
                            <div class="upload-demo-id-dos"></div>
                        </div>
                    </div>
                </div>
            </div>


            {!! Form::open(['route' => 'banners_menu_edit', 'files' => true, 'id' => 'form_banner_menu_dos']) !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="hidden" id="imagen_dos" name="imagen_dos" required="">
                        <input type="hidden" name="banner_menu" value='2' required="">
                    </div>
                </div>
            </div>


            <div class="row editar">
                
                <div class="col-sm-12">
                    <div class="datos-usuario">

                        <div class="form-group{{ $errors->has('enlace_dos') ? ' has-error' : '' }}">
                            {!! Form::text('enlace_dos', @$data['banners_menu']->enlace_dos, array('class' => 'form-control',  'placeholder' => 'Enlace banner HTTP://')) !!}
                            <div class="col-md-6">
                                @if ($errors->has('enlace_dos'))
                                    <span class="help-block">
                                        <strong>{!! $errors->first('enlace_dos') !!}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row submit">
                <div class="col-md-12">
                    <button type="buttom" class="submit-datos" id="send_form_dos">Guardar cambios</button>
                </div>
            </div>
            
            {!! Form::close() !!}
            
        </div>
    </div>  
</div>

@endsection

@section('JSpage')

    <script type="text/javascript">
        @if (isset($data['banners_menu']->imagen) && $data['banners_menu']->imagen != '')
            $('#upload-izq').ezdz({
              text: "<img src={!! asset($data['banners_menu']->imagen) !!} style='width:200px; height:100%'>",
            });
        @else
            $('#upload-izq').ezdz({
              text: "<img src={!! asset('img/arrastre-imagen.png') !!} style='width:200px; height:100%'>",
            });
        @endif
        
        @if (isset($data['banners_menu']->imagen_dos) && $data['banners_menu']->imagen_dos != '')
            $('#upload-der').ezdz({
              text: "<img src={!! asset($data['banners_menu']->imagen_dos) !!} style='width:200px; height:100%'>",
            });
        @else
            $('#upload-der').ezdz({
              text: "<img src={!! asset('img/arrastre-imagen.png') !!} style='width:200px; height:100%'>",
            });
        @endif
        
        
    </script>

<script src="{!! asset('js/croppie/croppie.js') !!}"></script>

<script>


    function upload() {
        var $uploadCropUno;
        var $uploadCropDos;

        $uploadCropUno = $('.upload-demo-id-uno').croppie({
            viewport: {
                width: 252,
                height: 240
            }
        });

        $uploadCropDos = $('.upload-demo-id-dos').croppie({
            viewport: {
                width: 252,
                height: 240
            }
        });

        //Detectamos la imagen y la pasamos al crop
        $('#upload-izq').on('change', function () { readFile_uno(this); });
        $('#upload-der').on('change', function () { readFile_dos(this); });

        function readFile_uno(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                
                reader.onload = function (e) {
                    $('#upload-demo-uno').addClass('ready');
                    $uploadCropUno.croppie('bind', {
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

        function readFile_dos(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                
                reader.onload = function (e) {
                    $('#upload-demo-dos').addClass('ready');
                    $uploadCropDos.croppie('bind', {
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

            $uploadCropUno.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $('#imagen').val(resp);
                $('#form_banner_menu_uno').submit();
            });
        });

        $('#send_form_dos').on('click', function (ev) {

            $uploadCropDos.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $('#imagen_dos').val(resp);
                $('#form_banner_menu_dos').submit();
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
<!-- or even simpler -->
@endsection
