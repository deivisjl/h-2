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
              <p class="text-center lead  titulo-herbalife">Productos</p>
                <div id="product">
                    @if(sizeof($productos) > 0)
                      @foreach($productos as $index => $producto)
                           @if($index%4 == 0)
                              <div class="row products products-big">                
                           @endif
                              <div class="col-sm-6 col-md-3">
                                  <div class="product">
                                      <div class="image"><a href="/detalle-producto/{{ $producto->id }}"><img src="{{ $producto->img_url }}" alt="" class="img-fluid image1"></a></div>
                                      <div class="text">
                                        <h3 class="h5"><a href="/detalle-producto/{{ $producto->id }}">{{ $producto->nombre }}</a></h3>
                                        <p class="price titulo-herbalife">Q. {{ $producto->precio }}</p>
                                      </div>
                                </div>
                              </div>
                           @if(($index+1)%4 == 0)   
                              </div>  
                           @endif  
                      @endforeach
                  @else
                  @endif
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
