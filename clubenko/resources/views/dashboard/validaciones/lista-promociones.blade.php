@extends('layouts.app')

@section('content')

<div class="container" id="content">
  @include('dashboard.validaciones.includes.submenu')

  <div class="listado-validaciones">
    @foreach($data['promociones'] as $promocion)
    <div class="row">
      <div class="col-md-3">
        <p class="elemento">{!! $promocion->titulo !!}</p>  
      </div>
      <div class="col-md-5">
        <div class="elemento">
          <a href="{{ route('promociones.show', $promocion->slug) }}" title="" target="_blank">{!! $promocion->descripcion_corta !!}</a>
        </div>
      </div>
      <div class="col-md-2 botones">
        <span><a class="btn btn-green" href="{!! route('validar-promocion', $promocion->slug) !!}">Validar</a></span>
      </div>
    </div>
    @endforeach
    {{ $data['promociones']->links() }}

  </div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-promociones li').addClass('active');
    $('.v-promociones').removeClass('hidden');
  </script>
@endsection