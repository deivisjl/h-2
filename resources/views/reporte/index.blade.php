@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <section class="content-header">
       <h3>Reportes <small>Reportes de ventas</small></h3>
    </section>
    <div class="panel panel-default">
        <div class="panel-body">
              <!--  -->
                <div>
                  <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                      <a type="button" class="btn btn-default btn-primary" href="#fecha" aria-controls="fecha" role="tab" data-toggle="tab" id="venta_fecha">Ventas por fecha</a>
                    </div>
                    <div class="btn-group" role="group">
                      <a type="button" class="btn btn-default" href="#categoria" aria-controls="categoria" role="tab" data-toggle="tab" class="titulo">Ventas por categorías</a>
                    </div>
                    <div class="btn-group" role="group">
                      <a type="button" class="btn btn-default" href="#asociado" aria-controls="asociado" role="tab" data-toggle="tab" class="titulo">Ventas por asociado</a>
                    </div>
                  </div>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="fecha">
                       @include('reporte.partials.reporte-fecha')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="categoria">
                      @include('reporte.partials.reporte-categoria')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="asociado">
                      @include('reporte.partials.reporte-asociado')
                    </div>
                  </div>
                </div>
                <!--  -->
            
        </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $(".btn-group > .btn").click(function(){
    
        if($(this).hasClass('btn-primary')){
             $('.btn-group >.btn.btn-primary').removeClass('btn-primary');
        } else {
             $('.btn-group >.btn.btn-primary').removeClass('btn-primary');
             $(this).addClass('btn-primary');
        }
  });
</script>
@endsection


