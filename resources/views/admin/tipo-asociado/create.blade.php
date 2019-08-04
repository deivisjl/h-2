@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<section class="content-header">
		   <h3>Tipo de asociado <small>Nuevo tipo</small></h3>
		   <ol class="breadcrumb" style="margin-top:15px">
			  <li><a href="{{ route('tipo-asociado.index') }}">Tipos de asociados</a></li>
			  <li class="active">Nuevo registro</li>
			</ol>
		</section>
		<div class="panel panel-default">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" action="{{ route('tipo-asociado.store') }}" id="form_registro">
				 		{{ csrf_field() }}
					 		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombre</label>
					 			<input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
					 			@if ($errors->has('nombre'))
                                    <span class="help-block">
                                        {{ $errors->first('nombre') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('descuento') ? ' has-error' : '' }}">
					 			<label class="control-label">Descuento</label>
					 			<input type="text" name="descuento" class="form-control" value="{{ old('descuento') }}">
					 			@if ($errors->has('descuento'))
                                    <span class="help-block">
                                        {{ $errors->first('descuento') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('puntos') ? ' has-error' : '' }}">
					 			<label class="control-label">Puntos</label>
					 			<input type="text" name="puntos" class="form-control" value="{{ old('puntos') }}">
					 			@if ($errors->has('puntos'))
                                    <span class="help-block">
                                        {{ $errors->first('puntos') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }}">
					 			<label class="control-label">Días <small>(lapso de tiempo)</small></label>
					 			<input type="text" name="dias" class="form-control" value="{{ old('dias') }}">
					 			@if ($errors->has('dias'))
                                    <span class="help-block">
                                        {{ $errors->first('dias') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('es_patrocinador') ? ' has-error' : '' }}">
					 			<label class="control-label">Es patrocinador</label>
					 			<select name="es_patrocinador" class="form-control">
					 				<option value="2" selected="selected">-- Seleccione una opción --</option>
					 				<option value="1">Sí</option>
					 				<option value="0">No</option>
					 			</select>
					 			@if ($errors->has('es_patrocinador'))
                                    <span class="help-block">
                                        {{ $errors->first('es_patrocinador') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('orden') ? ' has-error' : '' }}">
					 			<label class="control-label">Orden</label>
					 			<input type="text" name="orden" class="form-control" value="{{ old('orden') }}">
					 			@if ($errors->has('orden'))
                                    <span class="help-block">
                                        {{ $errors->first('orden') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group">
					 			<button type="submit" class="btn btn-primary pull-right" id="guardar">Guardar</button>
					 		</div>
				 		</form>
				 	</div>
				 </div>
			</div>
		</div>
	</div>
</div>
@endsection
