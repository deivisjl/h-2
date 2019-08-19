<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<style type="text/css">
			.table {
				    width: 100%;
				    max-width: 100%;
				    margin-bottom: 20px;
			}
			.table-bordered {
			    border: 1px solid #ddd;
			}

			table {
				    background-color: transparent;
				}

			table {
			    border-spacing: 0;
			    border-collapse: collapse;
			}


			.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
				    border: 1px solid #ddd;
				}
			.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
			    padding: 8px;
			    line-height: 1.42857143;
			    vertical-align: top;
			    border-top: 1px solid #ddd;
			}
			th {
			    text-align: left;
			}
			td, th {
			    padding: 0;
			}

			.panel-herbalife {
			    border-color: #7ac143;
			}
			.custom-table {
				    background-color: #69a938 !important;
				    color: #fff !important;
				}
	</style></style>
</head>
<body>
	<div class="row"  style="margin-bottom: 0px !important; line-height: 1;">
		<div class="col-xs-12 text-center">
			<img src="{{ asset('img/logo-verde.png') }}" alt="herbalife" class="img-rounded">
		</div>
	</div>
	<table width="100%">
		<tr>
			<th width="70%">Factura No. {{ $pedido->id }}</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;background-color: #7ac143; color:#fff;">DIA</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143; background-color: #7ac143; color:#fff;">MES</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143; background-color: #7ac143; color:#fff;">AÑO</th>
		</tr>
		<tr>
			<td width="70%"></td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $dia = \Carbon\Carbon::parse($pedido->created_at)->format('d') }}</td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $mes = \Carbon\Carbon::parse($pedido->created_at)->format('m') }}</td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $year = \Carbon\Carbon::parse($pedido->created_at)->format('Y') }}</td>
		</tr>
	</table>
	<br>

	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-herbalife" style="margin-bottom:1px!important;">
				<div class="panel-body">
					<table width="100%">
						<tr>
							<td width="20%"><strong>No. ID:</strong></td>
							<td width="80%"><span> {{ $pedido->asociado->id}}</span></td>
						</tr>
						<tr>
							<td width="20%"><strong>NOMBRE:</strong></td>
							<td width="80%"><span>{{ $pedido->asociado->nombres }} {{ $pedido->asociado->apellidos }}</span></td>
						</tr>
						<tr>
							<td width="20%"><strong>DIRECCION:</strong></td>
							<td width="80%"><span>{{ $pedido->asociado->pais->nombre }}</span></td>
						</tr>
						<tr>
							<td width="20%"><strong>NIT.:</strong></td>
							<td width="80%"><span>C / F</span></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-herbalife">
				<div class="panel-body">
					<table width="100%">
						<tr>
							<td width="20%"><strong>ENVIAR A:</strong></td>
							<td width="80%"><span>{{ $pedido->asociado->nombres }} {{ $pedido->asociado->apellidos }}</span></td>
						</tr>
						<tr>
							<td width="20%"><strong>DIRECCION:</strong></td>
							<td width="80%"><span>{{ $pedido->asociado->direccion }}</span></td>
						</tr>
						<tr>
							<td width="20%"><strong>TELEFONO.:</strong></td>
							<td width="80%"><span>{{ $pedido->asociado->telefono}}</span></td> 
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-herbalife">
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr class="custom-table">
								<th width="10%" class="text-center"><strong>CODIGO</strong></th>
								<th width="10%" class="text-center"><strong>CANTIDAD</strong></th>
								<th width="30%" class="text-center"><strong>DESCRIPCION</strong></th>
								<th width="20%" class="text-center"><strong>PRECIO UNITARIO</strong></th>
								<th width="10%" class="text-center"><strong>IMPORTE</strong></th>
							</tr>
						</thead>
						<tbody>
							@foreach($detalle as $item)
							<tr>
								<td class="text-center">{{ $item->codigo}}</td>
								<td class="text-center">{{ $item->cantidad }}</td>
								<td>{{ $item->producto->nombre }}</td>
								<td class="text-center">{{ $item->producto->precio}}</td>
								<td class="text-center">{{ $item->importe }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<table width="100%">
		<tr>
			<td  style="width: 33.33%">
				<table class="table table-bordered">
					<thead>
						<tr class="custom-table"><th class="text-center">SUBTOTAL</th></tr>
					</thead>
					<tbody><tr><td class="text-center"><strong>Q. {{ $pedido->total }}</strong></td></tr></tbody>
				</table>
			</td>
			<td style="width: 33.33%">
				<table class="table table-bordered">
					<thead>
						<tr class="custom-table"><th class="text-center">DESCUENTO</th></tr>
					</thead>
					<tbody><tr><td class="text-center"><strong>Q. {{ $pedido->descuento }}</strong></td></tr></tbody>
				</table>
			</td>
			<td style="width: 33.33%">
				<table class="table table-bordered">
					<thead>
						<tr class="custom-table"><th class="text-center">TOTAL</th></tr>
					</thead>
					<tbody><tr><td class="text-center"><strong>Q. {{ $pedido->monto }}</strong></td></tr></tbody>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>