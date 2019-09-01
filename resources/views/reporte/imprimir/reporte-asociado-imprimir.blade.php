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
	<div class="row text-center">
		<div class="col-md-12"><h4>Reporte de pedidos del
			<span>{{ $desde = \Carbon\Carbon::parse($desde)->format('d-m-Y') }}</span> al 
			<span>{{ $hasta = \Carbon\Carbon::parse($hasta)->format('d-m-Y') }}</span></h4></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Asocidado</th>
						<th>Tipo asociado</th>
						<th>No. pedido</th>
						<th>Total</th>
						<th>Fecha</th>
					</tr>
				</thead>
				<tbody>
					@foreach($asociado as $index => $item)
					<tr>
						<td>{{ $index + 1}}</td>
						<td>{{ $item->asociado }}</td>
						<td>{{ $item->tipo }}</td>
						<td>{{ $item->pedido }}</td>
						<td>Q. {{ $item->total }}</td>
						<td>Q. {{ $item->fecha }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	
	
</body>
</html>
