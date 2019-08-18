<hr>
<form action="#" class="form-inline">
	<div class="form-group">
		<label for="fecha-desde" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="desde" id="desde">
	</div>
	<div class="form-group">
		<label for="fecha-hasta" class="control-label">Fecha hasta</label>
		<input type="date" class="form-control" name="hasta" id="hasta">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
 	<table id="listar" class="table table-striped table-bordered table-hover">
	    <thead>
	      <tr>
	        <th style="width:15%; text-align: center">No.</th>
	        <th>Nombre asociado</th>                   
	        <th>Tipo de asociado</th>
	        <th>Monto total</th>
	      </tr>
	    </thead>
	</table>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button class="btn btn-success btn-lg"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
	</div>
</div>