<hr>
<form action="#" class="form-inline">
	<div class="form-group">
		<label for="categoria" class="control-label">Categoría</label>
		<select name="categoria_id" id="categoria_id" class="form-control">
			<option value="0">--Seleccione una opción</option>
		</select>
	</div>
	<div class="form-group">
		<label for="fecha" class="control-label">Fecha desde</label>
		<input type="date" class="form-control" name="fecha">
	</div>
	<div class="form-group">
		<button class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
	</div>
</form>
<br>
 	<table id="listar" class="table table-striped table-bordered table-hover">
	    <thead>
	      <tr>
	        <th style="width:15%; text-align: center">No.</th>
	        <th>Categoría</th>                   
	        <th>Total compra</th>
	      </tr>
	    </thead>
	</table>
<hr>
<div class="row">
	<div class="col-md-12 text-center">
		<button class="btn btn-success btn-lg"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
	</div>
</div>