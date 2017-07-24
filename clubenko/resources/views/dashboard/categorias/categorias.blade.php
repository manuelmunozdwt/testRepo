@extends('layouts.app');    

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
                                <div class="categoria-box" data-slug="{{ $categoria->slug }}">
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
                         <div class="">
                            <form id="editform" method="POST" action="">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    {!! Form::text('nombre','', array('class' => 'input-categorias' )) !!}
                                    {!! Form::submit('Editar', ['class' => 'btn-blue' ]) !!}
                                </div>
                                                    
                            </form> 
                        </div>
                        @if(has_permiso('Borrar categoría'))
                            <span  onclick="return confirm('¿Seguro que quiere borrar esta categoría?')">

                                <form id="deleteform" method="DELETE" action="">
                                    {{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
                                {{ Form::close() }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <p>¿No encuentras la categoría que necesitas? Créala:</p>
                        {!! Form::open(['method' => 'POST','route' => 'categorias.store']) !!}
                        <div class="form-group">
                            {!! Form::text('nombre','', array('class' => 'input-categorias' )) !!}
                            {!! Form::submit('Crear', ['class' => 'btn-blue' ]) !!}
                        </div>
                        {!! Form::close() !!}
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
            var slug = $(this).data('slug');
            var origen = window.location.origin;
            //console.log(origen);
            var url_local = origen+'/ClubEnko/public/nueva-categoria/'+slug;
            var url = origen+'/nueva-categoria/'+slug;            

            var url_local_borrar = origen+'/ClubEnko/public/categorias/categoria/'+slug+'/borrar';
            var url_borrar = origen+'/categorias/categoria/'+slug+'/borrar';

            $('#editform').attr('action', url);
            $('#deleteform').attr('action', url_borrar);

        });
    </script>
@endsection

