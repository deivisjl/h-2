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
	        <th>Producto</th>
	        <th>Categoría</th>                   
	        <th>Total compra</th>
	      </tr>
	    </thead>
	</table>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button class="btn btn-success btn-lg" id="imprimir_categoria"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
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
	              {'data': 'producto'},
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

	  $('#imprimir_categoria').on('click',function(e){
			e.preventDefault();

			var desde = $('#fecha_desde').val();
			var hasta = $('#fecha_hasta').val();
			var categoria = $('#categoria_id').val();

			if(!desde || !hasta)
			{
				toastr.error('El intervalo de fechas debe ser válido!!','Mensaje: ');
			}
			else
			{
				reporte_categoria_imprimir(desde,hasta,categoria);	
			}
		});

	  var reporte_categoria_imprimir = function(desde,hasta,categoria)
      {
        var loading = document.getElementById('loading');
          
            loading.classList.add("block-loading");

            var datos = {desde:desde,hasta:hasta,categoria:categoria};

            $.ajax({
                type:'GET',
                url:'/reportes-categoria-imprimir/show',
                data:datos,                    
                xhrFields: {
                    responseType: 'blob'
                },
                success:function(response,status,xhr)
                {
                    var filename = "";                   
                  var disposition = xhr.getResponseHeader('Content-Disposition');

                   if (disposition) {
                      var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                      var matches = filenameRegex.exec(disposition);
                      if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                  } 
                  var linkelem = document.createElement('a');
                  try {
                        var blob = new Blob([response], { type: 'application/octet-stream' });                        

                      if (typeof window.navigator.msSaveBlob !== 'undefined') {
                          //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                          window.navigator.msSaveBlob(blob, filename);
                      } else {
                          var URL = window.URL || window.webkitURL;
                          var downloadUrl = URL.createObjectURL(blob);

                          if (filename) { 
                              // use HTML5 a[download] attribute to specify filename
                              var a = document.createElement("a");

                              // safari doesn't support this yet
                              if (typeof a.download === 'undefined') {
                                  window.location = downloadUrl;
                              } else {

                                  a.href = downloadUrl;
                                  a.download = filename;
                                  document.body.appendChild(a);
                                  a.target = "_blank";
                                  a.click();
                              }
                          } else {
                              
                              window.location = downloadUrl;
                          }

                          setTimeout(function () {
                                URL.revokeObjectURL(downloadUrl);
                            }, 100); // Cleanup
                      }   

                  } catch (ex) {
                      console.log(ex);
                  }

                  loading.classList.remove('block-loading');                  
                },
                error: function(e)
                {
                    loading.classList.remove('block-loading'); 
                    
                    toastr.error('Error: ' + e.statusText,'');
                }
              });
      }
</script>
@endsection