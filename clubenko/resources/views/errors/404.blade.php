@extends('layouts.app')

@section('CSSHeader')
<style type="text/css">
  #wrapper{
    background-color: #121424;
  }
</style>
@stop

@section('content')
  <div class="container error403" id="content">
    <img src="{!! asset('img/404.jpg') !!}">
  </div>

@endsection

@section('JSpage')
@endsection