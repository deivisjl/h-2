@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-herbalife">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<ol class="breadcrumb">
						  <li><a href="{{ route('categorias.index') }}">Categorías</a></li>
						  <li class="active">Editar registro</li>
						</ol>				 		
				 	</div>
				 	<div class="col-md-12 text-center"><h4>Editar categoría</h4></div>
				 </div>
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" id="form_registro" action="{{ url('categorias', [$categoria->id]) }}" autocomplete="off">
	                    <input name="_method" type="hidden" value="PUT">
				 		{{ csrf_field() }}
					 		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombre</label>
					 			<input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}">
					 			@if ($errors->has('nombre'))
                                    <span class="help-block">
                                        {{ $errors->first('nombre') }}
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
@endsection