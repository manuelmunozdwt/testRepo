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
    @foreach($data['categorias'] as $categoria)
    <div class="row">
      <div class="col-md-7">
        <p class="elemento">{!! $categoria->nombre !!}</p>
      </div>
      <div class="botones">
        <span style="display:inline-block;" onclick="return confirm('¿Seguro que quiere borrar esta categoría?')">
          {{ Form::open(array('method' => 'DELETE', 'route' => array('categorias.destroy', $categoria->slug))) }}
          {{ Form::submit('Borrar', array('class' => 'btn btn-blue')) }}
          {{ Form::close() }}
        </span>
        <span><a class="btn btn-green" href="{!! route('validar-categoria', $categoria->slug) !!}">Validar</a></span>

      </div>
    </div>
    @endforeach
  </div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-categorias li').addClass('active');
    $('.v-categorias').removeClass('hidden');
  </script>
@endsection