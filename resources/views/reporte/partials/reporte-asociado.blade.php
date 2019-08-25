<hr>
<form action="" class="form-inline" id="form_asociado">
	<div class="form-group">
		<label for="asociado_id" class="control-label">Código de asociado</label>
		<input type="text" class="form-control" name="asociado_id" id="asociado_id">
	</div>
	<div class="form-group">
		<label for="fecha_desde" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="asociado_fecha_desde" id="asociado_fecha_desde">
	</div>
	<div class="form-group">
		<label for="fecha_hasta" class="control-label">Fecha hasta</label>
		<input type="date" class="form-control" name="asociado_fecha_hasta" id="asociado_fecha_hasta">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
<table id="listar_pedido" class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th style="width:15%; text-align: center">No.</th>
        <th>Asociado.</th>                   
        <th>Tipo asociado</th>                
        <th>Pedido No.</th>
        <th>Total</th>
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
@section('js-tercero')
<script>
	$('#form_asociado').on('submit', function(e){
		e.preventDefault();

		var asociado = $('#asociado_id').val();
		var asociado_fecha_desde = $('#asociado_fecha_desde').val();
		var asociado_fecha_hasta = $('#asociado_fecha_hasta').val();

		if(!asociado || !fecha_desde || !fecha_hasta)
		{
			toastr.error('Los campos de búsqueda son requeridos','Mensaje: ');
		}
		else
		{
			  var data = {asociado:asociado,fecha_desde:asociado_fecha_desde,fecha_hasta:asociado_fecha_hasta};
          
	          var parameters = new Array();
	          parameters.push(data);
	          listar_pedido(parameters);

		}
	})
	var  listar_pedido = function(parameters){
  
	    var table = $("#listar_pedido").DataTable({
	            "searching" : false,
	            "processing": true,
	            "serverSide": true,
	            "destroy":true,
	            "ajax":{
	            'url': '/reportes-pedido/show',
	            'type': 'GET',
	            'data': {
	                   'buscar': parameters
	            }
	          },
	          "columns":[
	              {'data': 'id'},
	              {'data': 'asociado'}, 
	              {'data': 'tipo'},
	              {'data': 'pedido'}, 
	              {'data': 'total', "render":function ( data, type, row, meta ) {
                                return '<span> Q. '+data+'</span>';
                               }, "searchable":false, "orderable":false
	           	  },
	           	  {'data':'fecha'}
	          ],
	          "language": idioma_spanish,

	          "order": [[ 0, "asc" ]]

	    });
	  }
</script>
@endsection