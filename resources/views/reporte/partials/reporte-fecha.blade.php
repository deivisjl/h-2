<hr>
<form action="" class="form-inline" id="reporte_fecha">
	<div class="form-group">
		<label for="fecha-desde" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="desde" id="desde">
	</div>
	<div class="form-group">
		<label for="fecha-hasta" class="control-label">Fecha hasta</label>
		<input type="date" class="form-control" name="hasta" id="hasta">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
 	<table id="listar" class="table table-striped table-bordered table-hover">
	    <thead>
	      <tr>
	        <th style="width:15%; text-align: center">No.</th>
	        <th>Nombre asociado</th>                   
	        <th>Tipo de asociado</th>
	        <th>Monto total</th>
	      </tr>
	    </thead>
	</table>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button class="btn btn-success btn-lg"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
	</div>
</div>

@section('js')
<script>
	$('#reporte_fecha').on('submit',function(e){
		e.preventDefault();

		var desde = $('#desde').val();
		var hasta = $('#hasta').val();

		if(!desde || !hasta)
		{
			toastr.error('El intervalo de fechas debe ser válido!!','Mensaje: ');
		}
		else
		{
			  var data = {date_from:desde,date_until:hasta};
          
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
	            'url': '/reportes-fecha/show',
	            'type': 'GET',
	            'data': {
	                   'buscar': parameters
	            }
	          },
	          "columns":[
	              {'data': 'id'},
	              {'data': 'asociado'}, 
	              {'data': 'tipo'},             
	              {'data': 'monto', "render":function ( data, type, row, meta ) {
                                return '<span> Q. '+data+'</span>';
                               }, "searchable":false
	           	  },
	          ],
	          "language": idioma_spanish,

	          "order": [[ 0, "asc" ]]

	    });
	  }
</script>
@endsection