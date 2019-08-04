@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-herbalife">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<ol class="breadcrumb">
						  <li><a href="{{ route('asociados.index') }}">Asociados</a></li>
						  <li class="active">Nuevo asociado</li>
						</ol>				 		
				 	</div>
				 <div class="col-md-12 text-center"><h4>Nuevo asociado</h4></div>
				 </div>
				 <form method="POST" action="{{ route('asociados.store') }}" id="form_registro" autocomplete="off">
				 	{{ csrf_field() }}
				 <div class="row">
				 	<div class="col-md-6">
					 		<div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombres</label>
					 			<input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}">
					 			@if ($errors->has('nombres'))
                                    <span class="help-block">
                                        {{ $errors->first('nombres') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }}">
					 			<label class="control-label">Apellidos</label>
					 			<input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}">
					 			@if ($errors->has('apellidos'))
                                    <span class="help-block">
                                        {{ $errors->first('apellidos') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('dpi') ? ' has-error' : '' }}">
					 			<label class="control-label">DPI</label>
					 			<input type="text" name="dpi" class="form-control" value="{{ old('dpi') }}">
					 			@if ($errors->has('dpi'))
                                    <span class="help-block">
                                        {{ $errors->first('dpi') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }}">
					 			<label class="control-label">Teléfono</label>
					 			<input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
					 			@if ($errors->has('telefono'))
                                    <span class="help-block">
                                        {{ $errors->first('telefono') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('correo_electronico') ? ' has-error' : '' }}">
					 			<label class="control-label">Correo electrónico</label>
					 			<input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}">
					 			@if ($errors->has('correo_electronico'))
                                    <span class="help-block">
                                        {{ $errors->first('correo_electronico') }}
                                    </span>
                                @endif
				 			</div>
				 			<div class="form-group {{ $errors->has('tipo_asociado') ? ' has-error' : '' }}">
					 			<label class="control-label">Tipo asociado</label>
					 			<select class="form-control" name="tipo_asociado">
					 				<option value="0">-- Seleccione una opción --</option>
					 				@foreach($tipos as $tipo)
					 				<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
					 				@endforeach
					 			</select>
					 			@if ($errors->has('tipo_asociado'))
	                                <span class="help-block">
	                                    {{ $errors->first('tipo_asociado') }}
	                                </span>
	                            @endif
					 		</div>
				 		
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
				 			<label class="control-label">País</label>
				 			<select class="form-control" name="pais" id="pais">
				 				<option value="0">-- Seleccione una opción --</option>
				 				@foreach($paises as $pais)
				 				<option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
				 				@endforeach
				 			</select>
				 			@if ($errors->has('pais'))
                                <span class="help-block">
                                    {{ $errors->first('pais') }}
                                </span>
                            @endif
				 		</div>
				 		<div class="form-group {{ $errors->has('departamento') ? ' has-error' : '' }}">
				 			<label class="control-label">Departamento</label>
				 			<select class="form-control" name="departamento" id="departamento">
				 				<option value="0">-- Seleccione una opción --</option>
				 			</select>
				 			@if ($errors->has('departamento'))
                                <span class="help-block">
                                    {{ $errors->first('departamento') }}
                                </span>
                            @endif
				 		</div>
				 		<div class="form-group {{ $errors->has('municipio') ? ' has-error' : '' }}">
				 			<label class="control-label">Municipio</label>
				 			<select class="form-control" name="municipio" id="municipio">
				 				<option value="0">-- Seleccione una opción --</option>
				 			</select>
				 			@if ($errors->has('municipio'))
                                <span class="help-block">
                                    {{ $errors->first('municipio') }}
                                </span>
                            @endif
				 		</div>
				 		<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }}">
				 			<label class="control-label">Dirección</label>
				 			<textarea name="direccion" class="form-control">{{ old('direccion') }}</textarea>
				 			@if ($errors->has('direccion'))
                                <span class="help-block">
                                    {{ $errors->first('direccion') }}
                                </span>
                            @endif
				 		</div>
				 		<div class="form-group {{ $errors->has('patrocinador') ? ' has-error' : '' }}">
				 			<label class="control-label">Patrocinador</label><small class="text-primary"> *opcional</small>
				 			<select class="form-control" name="patrocinador" id="patrocinador">
				 				<option value="0">Seleccione un patrocinador de la tabla</option>
				 			</select>
				 			@if ($errors->has('patrocinador'))
                                <span class="help-block">
                                    {{ $errors->first('patrocinador') }}
                                </span>
                            @endif
				 		</div>
				 	</div>
				 </div>
				 <div class="row">
				 	<div class="col-md-12">
				 		<table id="listar" class="table table-striped table-bordered table-hover">
		                    <thead>
		                      <tr>
		                        <th style="width:5%; text-align: center">No.</th>
		                        <th>Apellidos</th> 
		                        <th>Nombres</th>                   
		                        <th>DPI</th>
		                        <th>Teléfono</th>
		                        <th>Acción</th>
		                      </tr>
		                    </thead>
		                </table>
				 	</div>
				 </div>
					 <div class="form-group">
						 <button type="submit" class="btn btn-primary btn-block btn-lg" id="guardar">Guardar</button>
				 	</div>
		 		</form>
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

 $("#pais").on("change",function(e){
 	e.preventDefault();

 	var id = $("#pais").val();

 	 if(id > 0)
 	 {
 	 	obtener_departamentos(id);
 	 }
 });

 $("#departamento").on("change",function(e){
 	e.preventDefault();

 	var id = $("#departamento").val();

 	 if(id > 0)
 	 {
 	 	obtener_municipios(id);
 	 }
 });

 var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/asociados-listar/show',
            'type': 'GET'
          },
          "lengthMenu": [[5, 10, 15], [5, 10, 15]],
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-4'l><'col-sm-3'f><'col-sm-5'p>>",
          "columns":[
              {'data': 'id'},
              {'data': 'apellidos'},   
              {'data': 'nombres'},   
              {'data': 'dpi'},   
              {'data': 'telefono'},   
              {'defaultContent':'<a class="editar btn btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Seleccionar registro"><i class="glyphicon glyphicon-edit"></i> Seleccionar</a>', "orderable":false}
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
        var nombres = data.nombres;
        var apellidos = data.apellidos;

        var select = document.getElementById('patrocinador'); 
        select.options.length = 0;
		select.options[0] = new Option(nombres+' ' +apellidos,id);

      });
    }	

    var obtener_departamentos = function(id){
      loading = document.getElementById('loading');
          loading.classList.add("block-loading");

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
         var municipio = document.getElementById('municipio');                        
         municipio.options.length = 0;
         municipio.options[0] = new Option("-- Seleccione una opción --","0");
          
          $.ajax({
           url: '/asociados-departamento/'+id,
           type: 'GET',
           dataType: 'json',             
           success: function(res){
           	  var data = res.data;
              loading.classList.remove('block-loading');
               var select = document.getElementById('departamento');                        
               select.options.length = 0;

                  if(data.length > 0){
                      
                      select.options[0] = new Option("-- Seleccione un departamento --","0");

                      for(var i=0; i < data.length; i++){
                        select.options[i + 1] = new Option(data[i].nombre,data[i].id);
                      }

                   }
                   else
                   {
                        var select = document.getElementById('departamento');   
                        select.options[0] = new Option("-- No hay departamentos --","0");
                   }
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
           }
        });
    }

    var obtener_municipios = function(id){
    	loading = document.getElementById('loading');
          loading.classList.add("block-loading");

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          $.ajax({
           url: '/asociados-municipio/'+id,
           type: 'GET',
           dataType: 'json',             
           success: function(res){
              var data = res.data;
              loading.classList.remove('block-loading');
               var select = document.getElementById('municipio');                        
               select.options.length = 0;

                if(data.length > 0){
                      
	                      select.options[0] = new Option("-- Seleccione un municipio --","0");

	                      for(var i=0; i < data.length; i++){
	                        select.options[i + 1] = new Option(data[i].nombre,data[i].id);
	                      }

	                   }
	                   else
	                   {
	                        var select = document.getElementById('municipio');   
	                        select.options[0] = new Option("-- No hay municipios --","0");
	                   }
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
           }
        });
    }

$('#form_registro').on('submit',function(){
    $('#guardar').text('Guardando...');
});
</script>
@endsection