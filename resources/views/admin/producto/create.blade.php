@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<section class="content-header">
		   <h3>Productos <small>Nuevo producto</small></h3>
		   <ol class="breadcrumb" style="margin-top:15px">
			  <li><a href="{{ route('productos.index') }}">Productos</a></li>
			  <li class="active">Nuevo registro</li>
			</ol>
		</section>
		<div class="panel panel-default">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" action="{{ route('productos.store') }}" id="form_registro" accept-charset="UTF-8" enctype="multipart/form-data">
				 		{{ csrf_field() }}
				 			<div class="form-group {{ $errors->has('codigo') ? ' has-error' : '' }}">
					 			<label class="control-label">Código</label>
					 			<input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}">
					 			@if ($errors->has('codigo'))
                                    <span class="help-block">
                                        {{ $errors->first('codigo') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }}">
					 			<label class="control-label">Nombre</label>
					 			<input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
					 			@if ($errors->has('nombre'))
                                    <span class="help-block">
                                        {{ $errors->first('nombre') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('precio') ? ' has-error' : '' }}">
					 			<label class="control-label">Precio</label>
					 			<input type="text" name="precio" class="form-control" value="{{ old('precio') }}">
					 			@if ($errors->has('precio'))
                                    <span class="help-block">
                                        {{ $errors->first('precio') }}
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
					 		<div class="form-group {{ $errors->has('descripcion') ? ' has-error' : '' }}">
					 			<label class="control-label">Descripción</label>
					 			<textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
					 			@if ($errors->has('descripcion'))
                                    <span class="help-block">
                                        {{ $errors->first('descripcion') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('categoria') ? ' has-error' : '' }}">
					 			<label class="control-label">Categoría</label>
					 			<select name="categoria" class="form-control">
					 				<option value="0">-- Seleccione una opción --</option>
					 				@foreach($categorias as $categoria)
					 				<option value="{{ $categoria->id}}">{{ $categoria->nombre }}</option> 
					 				@endforeach
					 			</select>
					 			@if ($errors->has('categoria'))
                                    <span class="help-block">
                                        {{ $errors->first('categoria') }}
                                    </span>
                                @endif
					 		</div>
					 		<div class="form-group {{ $errors->has('imagen') ? ' has-error' : '' }}">
					 			<label class="control-label">Imagen</label>
					 			<input type="file" name="imagen" class="form-control" required="true">
					 			@if ($errors->has('imagen'))
                                    <span class="help-block">
                                        {{ $errors->first('imagen') }}
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
@section('js')
<script type="text/javascript" src="{{ asset('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')}}"></script>

 <script>
	  $(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
	    CKEDITOR.replace('descripcion')
	    //bootstrap WYSIHTML5 - text editor
	    $('.textarea').wysihtml5()
	  })
</script>

@endsection