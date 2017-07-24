@extends('layouts.app')

@section('content')

<div class="container">
    @if(Auth::user()->role->rol == 'Tienda')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mi tienda</div>
                <div class="panel-body">
                    <table class="table ">
                      <thead>
                        <tr>
                          <th>Nombre</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['lista-cupones']->tienda as $cupon)
                            @if($cupon->confirmado == 1 )
                            <tr>
                              <td>{!! $cupon->titulo !!}</td>

                              <td>
                                <a class="btn btn-default" href="{!! route('tiendas.show', $tienda->slug) !!}">Ver tienda</a>
                                <a class="btn btn-default" href="{!! route('tiendas.edit', $tienda->slug) !!}">Editar</a>
                              </td>
                            </tr>   
                              @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="col-md-12">
                        <a class="btn btn-default" href="{{ route('tiendas.create', $tienda) }}">Nueva tienda</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

