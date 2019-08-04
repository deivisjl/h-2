@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<section class="content-header">
		   <h3>Usuarios <small>Nuevo usuario</small></h3>
		   <ol class="breadcrumb" style="margin-top:15px">
			  <li><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
			  <li class="active">Nuevo registro</li>
			</ol>
		</section>
		<div class="panel panel-default">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" action="{{ route('usuarios.store') }}" id="form_registro">
				 		{{ csrf_field() }}
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
							
							<div class="form-group {{ $errors->has('genero') ? ' has-error' : '' }}">
								<label class="control-label">Género</label>
								<div class="clearfix"></div>
								<label class="radio-inline">
								  <input type="radio" name="genero" id="inlineRadio1" value="1" checked> Masculino
								</label>
								<label class="radio-inline">
								  <input type="radio" name="genero" id="inlineRadio2" value="2"> Femenino
								</label>
								@if ($errors->has('genero'))
                                    <span class="help-block">
                                        {{ $errors->first('genero') }}
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
					 		<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }}">
					 			<label class="control-label">Dirección</label>
					 			<input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
					 			@if ($errors->has('direccion'))
                                    <span class="help-block">
                                        {{ $errors->first('direccion') }}
                                    </span>
                                @endif
					 		</div>
				 			
				 			<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
					 			<label class="control-label">Correo electrónico</label>
					 			<input type="email" name="email" class="form-control" value="{{ old('email') }}">
					 			@if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
					 		</div>

					 		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Contraseña</label>
                                <input id="password" type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Repita contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="form-group {{ $errors->has('rol') ? ' has-error' : '' }}">
					 			<label class="control-label">Rol</label>
					 			<select name="rol" class="form-control">
					 				<option value="0">-- Seleccione una opción --</option>
					 				@foreach($roles as $rol)
					 				<option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
					 				@endforeach
					 			</select>
					 			@if ($errors->has('rol'))
                                    <span class="help-block">
                                        {{ $errors->first('rol') }}
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
