@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<section class="content-header">
		   <h3>Asociados <small>Editar asociado</small></h3>
		   <ol class="breadcrumb" style="margin-top:15px">
			  <li><a href="{{ route('asociados.index') }}">Asociados</a></li>
			  <li class="active">Nuevo registro</li>
			</ol>
		</section>
		<div class="panel panel-default">
			<div class="panel-body">
				 <form method="POST" id="form_registro" action="{{ url('asociados', [$asociado->id]) }}" autocomplete="off">
          <input name="_method" type="hidden" value="PUT">
          {{ csrf_field() }}
				 <div class="row">
				 	<div class="col-md-6">
					 		<div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombres</label>
					 			<input type="text" name="nombres" class="form-control" value="{{ $asociado->nombres }}">
					 			@if ($errors->has('nombres'))
                                    <span class="help-block">
                                        {{ $errors->first('nombres') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }}">
					 			<label class="control-label">Apellidos</label>
					 			<input type="text" name="apellidos" class="form-control" value="{{ $asociado->apellidos }}">
					 			@if ($errors->has('apellidos'))
                                    <span class="help-block">
                                        {{ $errors->first('apellidos') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('dpi') ? ' has-error' : '' }}">
					 			<label class="control-label">DPI</label>
					 			<input type="text" name="dpi" class="form-control" value="{{ $asociado->dpi }}">
					 			@if ($errors->has('dpi'))
                                    <span class="help-block">
                                        {{ $errors->first('dpi') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }}">
					 			<label class="control-label">Teléfono</label>
					 			<input type="text" name="telefono" class="form-control" value="{{ $asociado->telefono }}">
					 			@if ($errors->has('telefono'))
                                    <span class="help-block">
                                        {{ $errors->first('telefono') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('correo_electronico') ? ' has-error' : '' }}">
					 			<label class="control-label">Correo electrónico</label>
					 			<input type="email" name="correo_electronico" class="form-control" value="{{ $asociado->correo }}">
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
					 				<option value="{{ $tipo->id }}"
                  @if($tipo->id == $asociado->tipo_asociado_id)
                    selected="selected"
                  @endif
                  >{{ $tipo->nombre }}</option>
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
				 		<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }}">
				 			<label class="control-label">Dirección</label>
				 			<textarea name="direccion" class="form-control">{{ $asociado->direccion }}</textarea>
				 			@if ($errors->has('direccion'))
                                <span class="help-block">
                                    {{ $errors->first('direccion') }}
                                </span>
                            @endif
				 		</div>
				 	</div>
				 </div>
				 <div class="row">
				 </div>
					 <div class="form-group">
						 <button type="submit" class="btn btn-success btn-block btn-lg" id="guardar">Editar</button>
				 	</div>
		 		</form>
			</div>
		</div>
	</div>
</div>
@endsection
