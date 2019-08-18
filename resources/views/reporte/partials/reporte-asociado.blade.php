<hr>
<form action="#" class="form-inline">
	<div class="form-group">
		<label for="asociado_id" class="control-label">Código de asociado</label>
		<input type="text" class="form-control" name="asociado_id" id="asociado_id">
	</div>
	<div class="form-group">
		<label for="fecha_asociado" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="fecha_asociado">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="box box-widget widget-user">
			<div class="widget-user-header bg-aqua-active">
				<h2 class="widget-user-username">Alex Pierce</h2>
				<h4 class="widget-user-desc">Mayorista</h4>
			</div>
			<div class="widget-user-image">
				<img src="{{ asset('img/unknown-user.png') }}" alt="" class="img-circle">
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-md-12" style="text-align: justify;">
						<span style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus culpa reprehenderit temporibus, ipsum facere suscipit numquam voluptatem earum cupiditate beatae a sunt aliquam minima ipsam nemo eius laboriosam, deleniti, rerum.</span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button type="button" class="btn btn-success btn-lg" id="imprimir_asociado"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
	</div>
</div>