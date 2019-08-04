@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
       <div class="panel panel-herbalife">
          <div class="panel-body">
              <div class="row">
                  <div class="col-md-6"><h4>Comisiones</h4></div><!-- </div> -->
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th style="width:5%; text-align: center">No.</th>
                              <th>Nombre asociado</th>                   
                              <th>Monto</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
     $(function(){
          listar();
       });

    var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/comisiones/show',
            'type': 'GET'
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},   
              {'data': 'monto'},   
              {'defaultContent':'<a class="editar btn btn-primary btn-xs"  data-toggle="tooltip" data-placement="top" title="Pagar comisión"><i class="glyphicon glyphicon-pencil"></i> Pagar</a>', "orderable":false}
          ],
          "language": idioma_spanish,

          "order": [[ 0, "asc" ]]

        });
        obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
      $(tbody).on("click","a.editar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

        if(id > 0) 
        {
            pagar_comision(id);
        }

      });
    }

     var pagar_comision = function(id)
          {
            var loading = document.getElementById('loading');
              
                loading.classList.add("block-loading");

                $.ajax({
                    type:'GET',
                    url:'/comisiones/'+id+'/edit',                    
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
                      $('#listar').DataTable().ajax.reload(); 
                    },
                    error: function(e)
                    {
                        loading.classList.remove('block-loading'); 
                        $('#listar').DataTable().ajax.reload();
                        toastr.error('Error: ' + e.statusText,'');
                    }
                  });
          }

</script>
@endsection