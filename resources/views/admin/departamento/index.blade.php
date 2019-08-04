@extends('layouts.app')

@section('content')
<div class="panel panel-herbalife">
    <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <ol class="breadcrumb">
              <li><a href="{{ route('paises.index') }}">Paises</a></li>
              <li class="active">{{ $pais->nombre}}</li>
            </ol>           
          </div>
         </div>

        <div class="row">
            <div class="col-md-6"><h4>Departamentos del país {{ $pais->nombre}}</h4></div>
            <div class="col-md-6"><a href="/departamento-registrar/{{ $pais->id }}" class="btn btn-primary pull-right">Nuevo</a></div>
        </div>
        <input type="hidden" name="pais" value="{{ $pais->id }}" id="pais">
        <div class="row">
            <div class="col-md-12">
                <table id="listar" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:15%; text-align: center">No.</th>
                        <th>Nombre</th>   
                        <th>Municipios</th>                
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
          var id = $('#pais').val();
          var param = new Array();
          var obj = {'id':id};
          param.push(obj);
          listar(param);
       });

    var  listar = function(param){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/departamentos/show',
            'type': 'GET',
            'data': {
                   'buscar': param
            }
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},   
              {'defaultContent':'<a class="filtrar btn btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Ver registros"><i class="glyphicon glyphicon-filter"></i> Municipios</a>', "orderable":false},           
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

         window.location.href = "/departamentos/" + id + "/edit";

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
              window.location.href ="/departamento-municipio/"+id;
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
           url: '/departamentos/'+id,
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