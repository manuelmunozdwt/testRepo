@extends('layouts.app')

@section('CSSHeader')
<link rel="Stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.css" />
<link rel="stylesheet" href="{!! asset('css/croppie/croppie.css') !!} " />
@endsection

@section('content')


<div id="content">

    <div class="container" id="mi-cuenta">
        
        
{{--
        <div class="row">
            <div class="col-xs-12 section-title usuario">
                <p>Editar banner superior de la home</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                  <div class="actions">
                      <button class="basic-result">Result</button>
                  </div>
                    <div id="demo-basic"></div>
            </div>
        </div>

        <div>
            <img src="" id="img_crop" alt="">
        </div>
--}}
            
        <div class="row botones-usuario">
            <a class="gris editar">Sugerimos que subas una imagen de 1060px X 100px</a>
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


        

        {{--<div class="row">
            <div class="col-xs-12">
                @if($data['banner'] && $data['banner']->imagen !='')  
                    <img style="margin-top: 40px" src="{!! asset($data['banner']->imagen)!!}">
                @else
                    <img class="imagen-usuario" src="{!! asset('img/user.png') !!}">
                @endif
            </div>
        </div>--}}
        {!! Form::open(['route' => 'banner_cabecera_edit', 'files' => true, 'id' => 'form_banner_cabecera']) !!}
        <div class="row">
            <div class="form-group">
                <input type="hidden" id="imagen" name="imagen" required="">
            </div>
        </div>


        <div class="row datos-usuario editar">
            <div class="col-xs-12">

                <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                    {!! Form::text('nombre', @$data['banner']->nombre, array('class' => 'form-control',  'placeholder' => 'Nombre')) !!}
                    <div class="col-md-6">

                        @if ($errors->has('nombre'))
                            <span class="help-block">
                                <strong>{!! $errors->first('nombre') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('alt') ? ' has-error' : '' }}">
                    {!! Form::text('alt', @$data['banner']->alt, array('class' => 'form-control',  'placeholder' => 'Alt banner')) !!}
                    <div class="col-md-6">
                        @if ($errors->has('alt'))
                            <span class="help-block">
                                <strong>{!! $errors->first('alt') !!}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('enlace') ? ' has-error' : '' }}">
                    {!! Form::text('enlace', @$data['banner']->enlace, array('class' => 'form-control',  'placeholder' => 'Enlace banner HTTP://')) !!}
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

        <div class="row submit">
            <div class="col-md-12">
                <button type="buttom" class="submit-datos" id="send_form">Guardar cambios</button>
            </div>
        </div>
            {!! Form::close() !!}
    </div>
</div>
@endsection

@section('JSpage')
    <script type="text/javascript">
        @if (isset($data['banner']->imagen) && $data['banner']->imagen != '')
            $('#upload').ezdz({
              text: "<img src={!! asset(@$data['banner']->imagen)!!} style='width:100%; height:100%'>",
            });
        @else
            $('#upload').ezdz({
              text: "<img src={!! asset('img/arrastre-imagen.png') !!} style='width:200px; height:100%'>",
            });
        @endif
    </script>

<script src="{!! asset('js/croppie/croppie.js') !!}"></script>

<script>


    function upload() {
        var $uploadCrop;

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 1060,
                height: 100
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
                $('#form_banner_cabecera').submit();
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
