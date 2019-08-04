@extends('layouts.app')

@section('content')
<section class="content-header">
   <h3>Pedidos <small>Listado de pedidos</small></h3>
   <ol class="breadcrumb">
      <a href="{{ route('pedidos.create') }}" class="btn btn-primary pull-right">Nuevo registro</a>
   </ol>
</section>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table id="listar" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:5%; text-align: center">No.</th>
                        <th>Asociado</th> 
                        <th>Monto</th>                   
                        <th>PV acumulado</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                </table>
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
            'url': '/pedidos/show',
            'type': 'GET'
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'asociado'},   
              {'data': 'monto'},   
              {'data': 'pv_acumulado'},   
              {'data': 'fecha'},
              {'data': 'estado', "render":function(data, type, row, meta){
                                
                                if(data == 1){
                                  return '<span class="label label-success">En proceso</span>'
                                }else{
                                  return '<span class="label label-warning">Procesado</span>'
                                }
                                }
              },
              {'data': 'estado', "render":function(data, type, row, meta){
                    if(data == 1){
                        return '<a class="editar btn btn-primary btn-xs"  data-toggle="tooltip" data-placement="top" title="Procesar registro"><i class="glyphicon glyphicon-edit"></i> Procesar</a>'
                      }else{
                        return '<a class="editar btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Reimprimir registro"><i class="glyphicon glyphicon-print"></i> Reimprimir</a>'
                      }
                    }
              },   
              {'data': 'estado', "render":function(data, type, row, meta){
                    if(data == 0){
                        return ''
                      }else{
                        return '<a class="borrar btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>'
                      }
                    }, "orderable":false
              }
              
          ],
          "language": idioma_spanish,

          "order": [[ 4, "desc" ]]

        });
        obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
      $(tbody).on("click","a.editar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

        imprimir(id);         

      });

      $(tbody).on("click","a.borrar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

         if(id > 0)
           {
              borrar_registro(id);
           }

      });

    }

    var borrar_registro = function(id)
    {
      loading = document.getElementById('loading');
          loading.classList.add("block-loading");

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
           url: '/pedidos/'+id,
           type: 'DELETE',
           dataType: 'json',             
           success: function(res){
              loading.classList.remove('block-loading');
               $('#listar').DataTable().ajax.reload();
               toastr.success(res.data);
           },
           error: function(e){
              loading.classList.remove('block-loading');
                  switch(e.status)
                  {
                    case 422:
                      toastr.error(e.responseJSON.error,'');
                    break;
                    default:
                      toastr.error('Error: ' + e.statusText,'');
                    break;
                  }
               $('#listar').DataTable().ajax.reload();
           }
        });
    }

    var imprimir = function(id)
          {
            var loading = document.getElementById('loading');
              
                loading.classList.add("block-loading");

                $.ajax({
                    type:'GET',
                    url:'/pedidos-imprimir/'+id,                    
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