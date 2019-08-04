@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-herbalife">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<ol class="breadcrumb">
						  <li><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
						  <li class="active">Editar registro</li>
						</ol>				 		
				 	</div>
				 	<div class="col-md-12 text-center"><h4>Editar usuario</h4></div>
				 </div>
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" id="form_registro" action="{{ url('usuarios', [$usuario->id]) }}" autocomplete="off">
	                    <input name="_method" type="hidden" value="PUT">
				 		{{ csrf_field() }}
					 		<div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombres</label>
					 			<input type="text" name="nombres" class="form-control" value="{{ $usuario->nombres }}">
					 			@if ($errors->has('nombres'))
                                    <span class="help-block">
                                        {{ $errors->first('nombres') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }}">
					 			<label class="control-label">Apellidos</label>
					 			<input type="text" name="apellidos" class="form-control" value="{{ $usuario->apellidos }}">
					 			@if ($errors->has('apellidos'))
                                    <span class="help-block">
                                        {{ $errors->first('apellidos') }}
                                    </span>
                                @endif
					 		</div>
							
							<div class="form-group {{ $errors->has('genero') ? ' has-error' : '' }}">
								<label class="control-label">Género</label>
								<div class="clearfix"></div>
								<label class="radio-inline">
								  <input type="radio" name="genero" id="inlineRadio1" value="1"
								  @if($usuario->sexo == 1)
								  	checked="checked"
								  @endif
								  > Masculino
								</label>
								<label class="radio-inline">
								  <input type="radio" name="genero" id="inlineRadio2" value="2"
								  @if($usuario->sexo == 2)
								  	checked="checked"
								  @endif
								  > Femenino
								</label>
								@if ($errors->has('genero'))
                                    <span class="help-block">
                                        {{ $errors->first('genero') }}
                                    </span>
                                @endif
							</div>

							<div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }}">
					 			<label class="control-label">Teléfono</label>
					 			<input type="text" name="telefono" class="form-control" value="{{ $usuario->telefono }}">
					 			@if ($errors->has('telefono'))
                                    <span class="help-block">
                                        {{ $errors->first('telefono') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }}">
					 			<label class="control-label">Dirección</label>
					 			<input type="text" name="direccion" class="form-control" value="{{ $usuario->direccion }}">
					 			@if ($errors->has('direccion'))
                                    <span class="help-block">
                                        {{ $errors->first('direccion') }}
                                    </span>
                                @endif
					 		</div>
				 			

                        <div class="form-group {{ $errors->has('rol') ? ' has-error' : '' }}">
					 			<label class="control-label">Rol</label>
					 			<select name="rol" class="form-control">
					 				<option value="0">-- Seleccione una opción --</option>
					 				@foreach($roles as $rol)
					 				<option value="{{ $rol->id }}"
					 				@if($usuario->rol_id == $rol->id)
					 					selected="selected"
					 				@endif
					 				>{{ $rol->nombre }}</option>
					 				@endforeach
					 			</select>
					 			@if ($errors->has('rol'))
                                    <span class="help-block">
                                        {{ $errors->first('rol') }}
                                    </span>
                                @endif
					 		</div>

					 		<div class="form-group">
					 			<button type="submit" class="btn btn-success pull-right" id="guardar">Editar</button>
					 		</div>
				 		</form>
				 	</div>
				 </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$('#form_registro').on('submit',function(){
    $('#guardar').text('Editando...');
});
</script>
@endsection