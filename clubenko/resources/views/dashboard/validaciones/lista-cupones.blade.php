@extends('layouts.app')

@section('content')

<div class="container" id="content">
  @include('dashboard.validaciones.includes.submenu')

  <div class="listado-validaciones">
    @foreach($data['cupones'] as $cupon)
    <div class="row">
      <div class="col-md-3">
        <p class="elemento">{!! $cupon->titulo !!}</p>  
      </div>
      <div class="col-md-5">
        <div class="elemento">
          <a href="{{ route('cupones.show', $cupon->slug) }}" title="" target="_blank">{!! $cupon->descripcion_corta !!}</a>
        </div>
      </div>
      <div class="col-md-2 botones">
        <span><a class="btn btn-green" href="{!! route('validar-cupon', $cupon->slug) !!}">Validar</a></span>
      </div>
    </div>
    @endforeach
    {{ $data['cupones']->links() }}

  </div>
</div>

@endsection

@section('JSpage')
  <script type="text/javascript">
    $('.v-cupones li').addClass('active');
    $('.v-cupones').removeClass('hidden');
  </script>
@endsection