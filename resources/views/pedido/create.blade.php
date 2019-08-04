@extends('layouts.app')

@section('content')
	<div class="row">
	 	<div class="col-md-10 col-md-offset-1">
	 		<ol class="breadcrumb">
			  <li><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
			  <li class="active">Nuevo pedido</li>
			</ol>				 		
	 	</div>
	 </div>
	<pedido-component></pedido-component>
@endsection
