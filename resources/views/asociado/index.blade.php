@extends('layouts.app')

@section('content')
<section class="content-header">
   <h3>Asociados <small>Asociados en el sistema</small></h3>
   <ol class="breadcrumb">
      <a href="{{ route('asociados.create') }}" class="btn btn-primary pull-right">Nuevo registro</a>
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
                        <th>Apellidos</th> 
                        <th>Nombres</th>                   
                        <th>DPI</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Tipo asociado</th>
                        <th>Acción</th>
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
            'url': '/asociados/show',
            'type': 'GET'
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'apellidos'},   
              {'data': 'nombres'},   
              {'data': 'dpi'},   
              {'data': 'direccion'},   
              {'data': 'telefono'},   
              {'data': 'email'},   
              {'data': 'tipo'},  
              {'defaultContent':'<a class="editar btn btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="glyphicon glyphicon-edit"></i> Editar</a> <a class="borrar btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>', "orderable":false}
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

         window.location.href = "/asociados/" + id + "/edit";

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
           url: '/asociados/'+id,
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