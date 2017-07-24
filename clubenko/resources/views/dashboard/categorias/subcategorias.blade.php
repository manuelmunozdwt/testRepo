@extends(Auth::user()->rol == 3 ? 'layouts.public-movile' : 'layouts.comercio');    

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
                    <a class="creacion" href=""><li class="">SUBCATEGORÍAS</li></a>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="submenu-comercio submenu-item-description">
                <div class="imagen-categoria-box">
                    <img class="cat-img" src="{!! asset($data['categoria']->imagen) !!}">
                    <p>{!! $data['categoria']->nombre !!}</p>
                </div>  
                <div class="subcategorias">
                    @foreach($data['categoria']->subcategoria->where('confirmado', 1)->chunk(3) as $chunk)
                    <div class="row">
                        @foreach($chunk as $subcategoria)
                        <div class="col-md-4">
                            <p><span id="subcategoria{!!$subcategoria->id!!}" class="bullet" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-slug="{!!  $subcategoria->slug !!}" data-categoria="{!! $data['categoria']->slug !!}"></span>  <span >{!! $subcategoria->nombre !!}</span></p>
                        </div>
                        @endforeach
                    </div>
                    
                    @endforeach
                </div>
                <div class="collapse" id="collapseExample">
                     <div class="">
                        <form id="editform" method="POST" action="">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                {!! Form::text('nombre',' ', array('class' => 'input-categorias' )) !!}
                                {!! Form::submit('Editar', ['class' => 'btn-blue' ]) !!}
                            </div>
                                                
                        </form> 
                    </div>
                    @if(has_permiso('Borrar subcategoría'))
                    <span  onclick="return confirm('¿Seguro que quiere borrar esta subcategoría?')">
                        <form id="deleteform" method="DELETE" action="">
                        {{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
                        {{ Form::close() }}
                    </span>
                    @endif
                </div>
                <div>
                    <p>¿No encuentras la subcategoría que necesitas? Créala:</p>
                    {!! Form::open(['method' => 'POST','route' => 'subcategorias.store']) !!}
                    {!! Form::hidden('categoria_id', $data['categoria']->id) !!}
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
                <p></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('JSpage')
    <script type="text/javascript">
        $('.creacion li').addClass('active');

        $('.bullet').on('click', function(){
            $('.bullet').removeClass('active');
            $(this).addClass('active');
        });


    </script>

    <script type="text/javascript">
        $('.bullet').on('click', function(){
            var slug = $(this).data('slug');
            var categoria= $(this).data('categoria');
            var url = window.location.origin;
            var url_local = window.location.origin+'/ClubEnko/public';

            console.log(url+'/subcategoria/'+slug+'/borrar');
            $('#editform').attr('action', url+'/categorias/'+categoria+'/subcategorias/'+slug);
            $('#deleteform').attr('action', url+'/subcategorias/subcategoria/'+slug+'/borrar');
        });
    </script>

@endsection