@extends('layouts.landing')

@section('content')
<div id="content">
        <div class="container-fluid">
          <div class="row bar">
            <div class="col-md-3">
              <!-- MENUS AND FILTERS-->
              <div class="panel panel-herbalife sidebar-menu">
                <div class="panel-heading">
                  <h3 class="panel-title">Categorías</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                      @foreach($categorias as $categoria)
                        <li class="list-group-item"><span class="badge">{{ $categoria->total }}</span><a href="/categoria/{{ $categoria->slug }}">{{ $categoria->nombre}} </a></li>
                      @endforeach
                    </ul>
                </div>
              </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                  <div class="col-md-12">
                      <h1 class="titulo-herbalife">{{ $producto->nombre }}</h1>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-4">
                         <img src="{{ $producto->img_url}}" class="img-fluid" style="display:block; margin:auto">
                     </div>
                     <div class="col-md-8">
                          <span>{!!$producto->descripcion!!}</span>
                     </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="barra barra-sm text-center"><h2>Q. {{ $producto->precio }}</h2></div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
