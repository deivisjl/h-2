<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<style type="text/css">
		.panel-herbalife {
			    border-color: #7ac143;
			}

			.panel-herbalife > .panel-heading {
			    color: #fff;
			    background-color: #7ac143;
			    border-color: #7ac143;
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
			<th width="70%">COMPROBANTE DE PAGO DE COMISION</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;background-color: #7ac143; color:#fff;">DIA</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143; background-color: #7ac143; color:#fff;">MES</th>
			<th width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143; background-color: #7ac143; color:#fff;">AÑO</th>
		</tr>
		<tr>
			<td width="70%"></td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $dia = \Carbon\Carbon::parse($fecha)->format('d') }}</td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $mes = \Carbon\Carbon::parse($fecha)->format('m') }}</td>
			<td width="10%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $year = \Carbon\Carbon::parse($fecha)->format('Y') }}</td>
		</tr>
	</table>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-herbalife" style="margin-bottom:1px!important;">
				<div class="panel-body">
					<table width="100%">
						<tr>
							<td width="20%"><strong>NOMBRE:</strong></td>
							<td width="80%"><span>{{ $comision->nombre }}</span></td>
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
			<div class="panel panel-herbalife" style=" margin-bottom: 1px;">
				<div class="panel-heading text-center"><strong>DESCRIPCION</strong></div>
				<div class="panel-body text-center">
					<br>
					<span>Pago de comisión por venta de productos</strong>
					<br>
					<br>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table width="100%">
					<tr>
					    <th width="70%"></th>
						<th width="15%" class="text-center table-bordered" style="border: 1px solid #7ac143;background-color: #7ac143; color:#fff;">TOTAL Q. </th>
						<th width="15%" class="text-center table-bordered" style="border: 1px solid #7ac143;">{{ $comision->monto }}</th>
						
					</tr>
				</table>	
		</div>
	</div>
</body>
</html>