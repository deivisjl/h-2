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
		<button class="btn btn-success btn-lg" id="imprimir-fecha"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
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

	$('#imprimir-fecha').on('click',function(e){
		e.preventDefault();

		var desde = $('#desde').val();
		var hasta = $('#hasta').val();

		if(!desde || !hasta)
		{
			toastr.error('El intervalo de fechas debe ser válido!!','Mensaje: ');
		}
		else
		{
			reporte_fecha_imprimir(desde,hasta);	
		}
	});

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
                               }, "searchable":false, "orderable":false
	           	  },
	          ],
	          "language": idioma_spanish,

	          "order": [[ 0, "asc" ]]

	    });
	  }

	  var reporte_fecha_imprimir = function(desde,hasta)
      {
        var loading = document.getElementById('loading');
          
            loading.classList.add("block-loading");

            var datos = {desde:desde,hasta:hasta};

            $.ajax({
                type:'GET',
                url:'/reportes-fecha-imprimir/show',
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