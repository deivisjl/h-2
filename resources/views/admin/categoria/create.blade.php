@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<section class="content-header">
		   <h3>Categorías <small>Nuevo registro</small></h3>
		    <ol class="breadcrumb" style="margin-top:15px">
			  <li><a href="{{ route('categorias.index') }}">Categorías</a></li>
			  <li class="active">Nuevo registro</li>
			</ol>
		</section>
		<div class="panel panel-default">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" action="{{ route('categorias.store') }}" id="form_registro">
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
<script type="text/javascript">
$('#form_registro').on('submit',function(){
    $('#guardar').text('Guardando...');
});
</script>
@endsection