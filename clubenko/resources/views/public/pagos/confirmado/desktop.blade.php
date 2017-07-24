@extends('layouts.public-desktop')

@section('title') {!! Config::get('constantes.cliente') !!} @endsection

@section('CSSHeader')

{!! Html::style('css/public/desktop-style.css') !!}

{!! Html::style('css/public/pagos.css') !!}
<style type="text/css">
  .rating {
}
</style>
@endsection

@section('content')
<section class="main">
  <div class="row">
    <div class="ls-resp-main">
      <form id="master_form" autocomplete="on" data-bhw="ConfirmationForm" class="crystal" method="post" data-parsley-validate="" onsubmit="return false;" novalidate="" data-bhw-path="ConfirmationForm">

  <div class="row head">

    <div id="mod-welcome" style="text-align: center;">
        <h1>Su pago ha sido procesado correctamente</h1>
        <h2>Por favor, descargue el PDF. Recuerde que debe llevarlo para consumir su promoción. </h2>
    </div>

  </div>
  <div class="row main">

    <div id="main" class="left columns twelve" style="min-height: 585px;">
      <div style="width: 150px;margin: auto; margin-top:20px">
        <img src="{{ asset('img/pagos/icono-check-verde.png') }}" alt="">
      </div>

      <div style="text-align: center; margin-top:30px">
        No olvide descargar su <a href="{!! url('promocion-pdf', $data['slug']) !!}">promoción</a>. Volver a al <a href="{{ route('home') }}">Inicio</a>
      </div>
      
      </div>
  </div>
</section>
@endsection

@section('JSpage')

@endsection