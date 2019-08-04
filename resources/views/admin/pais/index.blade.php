@extends('layouts.app')

@section('content')
<section class="content-header">
   <h3>Países <small>Listado de países</small></h3>
   <ol class="breadcrumb">
      <a href="{{ route('paises.create') }}" class="btn btn-primary pull-right">Nuevo registro</a>
   </ol>
</section>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table id="listar" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:15%; text-align: center">No.</th>
                        <th>Nombre</th>   
                        <th>Departamentos</th>                
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
            'url': '/paises/show',
            'type': 'GET'
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},   
              {'defaultContent':'<a class="filtrar btn btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Ver registros"><i class="glyphicon glyphicon-filter"></i> Departamentos</a>', "orderable":false},           
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

         window.location.href = "/paises/" + id + "/edit";

      });

      $(tbody).on("click","a.borrar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

         if(id > 0)
           {
              borrar_registro(id);
           }

      });

      $(tbody).on("click","a.filtrar",function(){
        var data = table.row($(this).parents("tr")).data();
        
        var id = data.id;

         if(id > 0)
           {
              window.location.href ="/pais-departamento/"+id;
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
           url: '/paises/'+id,
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