@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <section class="content-header">
       <h3>Comisiones <small>{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</small></h3>
    </section>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="" class="form-inline" id="form_asociado">
                      <input type="hidden" value="{{ Auth::user()->id }}" id="asociado">
                        <div class="form-group">
                            <label for="fecha_desde" class="control-label">Fecha desde</label>
                            <input type="date" class="form-control" id="fecha_desde">
                        </div>
                        <div class="form-group">
                            <label for="fecha_hasta" class="control-label">Fecha hasta</label>
                            <input type="date" class="form-control" id="fecha_hasta">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                    <br>
                    <table id="listar" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th style="width:15%; text-align: center">No.</th>
                            <th>Titular del pedido</th>                   
                            <th>Pedido No.</th>
                            <th>Comisión</th>
                            <th>Fecha</th>
                          </tr>
                        </thead>
                    </table>
                    <hr>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-success btn-lg" id="imprimir_asociado"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $('#form_asociado').on('submit',function(e){
    e.preventDefault();

    var asociado = $('#asociado').val();
    var desde = $('#fecha_desde').val();
    var hasta = $('#fecha_hasta').val();

    if(!desde || !hasta)
    {
      toastr.error('El intervalo de fechas debe ser válido!!','Mensaje: ');
    }
    else
    {
        var data = {asociado:asociado,date_from:desde,date_until:hasta};
          
            var parameters = new Array();
            parameters.push(data);
            listar(parameters);

    }
  })

   var  listar = function(parameters){
  
      var table = $("#listar").DataTable({
              "searching" : false,
              "processing": true,
              "serverSide": true,
              "destroy":true,
              "ajax":{
              'url': '/reportes-asociado/show',
              'type': 'GET',
              'data': {
                     'buscar': parameters
              }
            },
            "columns":[
                {'data': 'id'},
                {'data': 'asociado'}, 
                {'data': 'pedido'},             
                {'data': 'monto', "render":function ( data, type, row, meta ) {
                                return '<span> Q. '+data+'</span>';
                               }, "searchable":false, "orderable":false
                },
                {'data': 'fecha'}, 
            ],
            "language": idioma_spanish,

            "order": [[ 0, "asc" ]]

      });
    }
</script>
@endsection


