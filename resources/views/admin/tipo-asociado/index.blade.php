@extends('layouts.app')

@section('content')
<div class="panel panel-herbalife">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6"><h4>Tipo de asociados</h4></div>
            <div class="col-md-6"><a href="{{ route('tipo-asociado.create') }}" class="btn btn-primary pull-right">Nuevo</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="listar" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:5%; text-align: center">No.</th>
                        <th>Nombre</th>                   
                        <th>Descuento %</th>
                        <th>Puntos</th>
                        <th>Lapso (días)</th>
                        <th>Es patrocinador</th>
                        <th>Orden</th>
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
            'url': '/tipo-asociado/show',
            'type': 'GET'
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},   
              {'data': 'descuento'},  
              {'data': 'pv'},  
              {'data': 'dias'},
              {'data': 'regalia', "render":function(data, type, row, meta){
                                
                                if(data == 1){
                                  return '<span class="label label-success">Si</span>'
                                }else{
                                  return '<span class="label label-warning">No</span>'
                                }
                                }
              },
              {'data': 'orden'},    
              {'defaultContent':'<a class="editar btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="glyphicon glyphicon-edit"></i> Editar</a> <a class="borrar btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,

          "order": [[ 5, "asc" ]]

        });
        obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
      $(tbody).on("click","a.editar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

         window.location.href = "/tipo-asociado/" + id + "/edit";

      });

      $(tbody).on("click","a.borrar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

         if(id > 0)
           {
               alert('en construcción...');
              //borrar_registro(id);
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
           url: '/tipo-asociado/'+id,
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
</script>
@endsection