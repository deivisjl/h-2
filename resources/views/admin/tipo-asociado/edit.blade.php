@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-herbalife">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<ol class="breadcrumb">
						  <li><a href="{{ route('tipo-asociado.index') }}">Tipo asociado</a></li>
						  <li class="active">Editar registro</li>
						</ol>				 		
				 	</div>
				 	<div class="col-md-12 text-center"><h4>Editar tipo</h4></div>
				 </div>
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" id="form_registro" action="{{ url('tipo-asociado', [$tipo->id]) }}" autocomplete="off">
	                    <input name="_method" type="hidden" value="PUT">
				 		{{ csrf_field() }}
					 		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombre</label>
					 			<input type="text" name="nombre" class="form-control" value="{{ $tipo->nombre }}">
					 			@if ($errors->has('nombre'))
                                    <span class="help-block">
                                        {{ $errors->first('nombre') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('descuento') ? ' has-error' : '' }}">
					 			<label class="control-label">Descuento</label>
					 			<input type="text" name="descuento" class="form-control" value="{{ $tipo->descuento }}">
					 			@if ($errors->has('descuento'))
                                    <span class="help-block">
                                        {{ $errors->first('descuento') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('puntos') ? ' has-error' : '' }}">
					 			<label class="control-label">Puntos</label>
					 			<input type="text" name="puntos" class="form-control" value="{{ $tipo->pv }}">
					 			@if ($errors->has('puntos'))
                                    <span class="help-block">
                                        {{ $errors->first('puntos') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }}">
					 			<label class="control-label">Días <small>(lapso de tiempo)</small></label>
					 			<input type="text" name="dias" class="form-control" value="{{ $tipo->dias }}">
					 			@if ($errors->has('dias'))
                                    <span class="help-block">
                                        {{ $errors->first('dias') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('es_patrocinador') ? ' has-error' : '' }}">
					 			<label class="control-label">Es patrocinador</label>
					 			<select name="es_patrocinador" class="form-control">
					 				<option value="2">-- Seleccione una opción --</option>
					 				<option value="1"
					 				@if($tipo->regalia == 1)
					 					selected="selected"
					 				@endif
					 				>Sí</option>
					 				<option value="0"
					 				@if($tipo->regalia == 0)
					 					selected="selected"
					 				@endif
					 				>No</option>
					 			</select>
					 			@if ($errors->has('es_patrocinador'))
                                    <span class="help-block">
                                        {{ $errors->first('es_patrocinador') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('orden') ? ' has-error' : '' }}">
					 			<label class="control-label">Orden</label>
					 			<input type="text" name="orden" class="form-control" value="{{ $tipo->orden }}">
					 			@if ($errors->has('orden'))
                                    <span class="help-block">
                                        {{ $errors->first('orden') }}
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