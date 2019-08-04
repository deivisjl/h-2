@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-herbalife">
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-12">
				 		<ol class="breadcrumb">
				 		  <li><a href="{{ route('paises.index') }}">Paises</a></li>
						  <li><a href="/pais-departamento/{{ $pais->id }}">{{ $pais->nombre }}</a></li>
						  <li class="active">Nuevo departamento</li>
						</ol>				 		
				 	</div>
				 	<div class="col-md-12 text-center"><h4>Nuevo departamento</h4></div>
				 </div>
				 <div class="row">
				 	<div class="col-md-12">
				 		<form method="POST" action="{{ route('departamentos.store') }}" id="form_registro">
				 		{{ csrf_field() }}
				 			<input type="hidden" name="pais" value="{{ $pais->id }}">

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