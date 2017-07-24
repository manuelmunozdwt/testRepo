@extends('layouts.app')

@section('content')

<div class="container" id="content">
  @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
  @endif

  @include('dashboard.validaciones.includes.submenu')

  <div class="listado-validaciones">
    @foreach($data['subcategorias'] as $subcategoria)
      @if($subcategoria->categoria != null)
      <div class="row">
        <div class="col-md-4">
          <ul class="elemento">
            <li class="nombre-elemento">Categoría</li>
            <li>{!! $subcategoria->categoria->nombre !!}</li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="elemento">
            <li class="nombre-elemento">Nueva subcategoría</li>
            <li>{!! $subcategoria->nombre !!}</li>
          </ul>
        </div>
        <div class="botones">
          <span style="display:inline-block;" onclick="return confirm('¿Seguro que quiere borrar esta subcategoría?')">
            {{ Form::open(array('method' => 'DELETE', 'route' => array('subcategorias.destroy', $subcategoria->slug))) }}
            {{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
            {{ Form::close() }}
          </span>
          <span><a class="btn btn-green" href="{!! route('validar-subcategoria', $subcategoria->slug) !!}">Validar</a></span>
        </div>

      </div>
      @endif
    @endforeach
  </div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-subcategorias li').addClass('active');
    $('.v-subcategorias').removeClass('hidden');
  </script>
@endsection