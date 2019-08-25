<hr>
<form action="" class="form-inline" id="reporte_categoria" method="POST">
	<div class="form-group">
		<label for="categoria" class="control-label">Categoría</label>
		<select name="categoria_id" id="categoria_id" class="form-control">
			<option value="0">--Seleccione una opción --</option>
			@foreach($categorias as $categoria)
			<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label for="fecha" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="fecha_desde" id="fecha_desde">
	</div>
	<div class="form-group">
		<label for="fecha" class="control-label">Fecha hasta</label>
		<input type="date" class="form-control" name="fecha_hasta" id="fecha_hasta">
	</div>
	<div class="form-group">
		<button class="btn btn-primary" id="form_categoria" name="form_categoria"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
 	<table id="listar_categoria" class="table table-striped table-bordered table-hover">
	    <thead>
	      <tr>
	        <th style="width:15%; text-align: center">No.</th>
	        <th>Categoría</th>                   
	        <th>Total compra</th>
	      </tr>
	    </thead>
	</table>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button class="btn btn-success btn-lg"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
	</div>
</div>
@section('js-secondary')
<script>
	$('#reporte_categoria').on('submit', function(e){
		e.preventDefault();

		var categoria = $('#categoria_id').val();
		var fecha_desde = $('#fecha_desde').val();
		var fecha_hasta = $('#fecha_hasta').val();

		if(!categoria || !fecha_desde || !fecha_hasta)
		{
			toastr.error('Los campos de búsqueda son requeridos','Mensaje: ');
		}
		else
		{
			  var data = {categoria:categoria,fecha_desde:fecha_desde,fecha_hasta:fecha_hasta};
          
	          var parameters = new Array();
	          parameters.push(data);
	          listar_categorias(parameters);

		}
	})
	var  listar_categorias = function(parameters){
  
	    var table = $("#listar_categoria").DataTable({
	            "searching" : false,
	            "processing": true,
	            "serverSide": true,
	            "destroy":true,
	            "ajax":{
	            'url': '/reportes-categoria/show',
	            'type': 'GET',
	            'data': {
	                   'buscar': parameters
	            }
	          },
	          "columns":[
	              {'data': 'id'},
	              {'data': 'categoria'}, 
	              {'data': 'monto', "render":function ( data, type, row, meta ) {
                                return '<span> Q. '+data+'</span>';
                               }, "searchable":false, "orderable":false
	           	  },
	          ],
	          "language": idioma_spanish,

	          "order": [[ 0, "asc" ]]

	    });
	  }
</script>
@endsection