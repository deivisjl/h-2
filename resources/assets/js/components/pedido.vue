<template>
	<div>
	<div v-if="loading" class="block-loading "></div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-herbalife">
					<div class="panel-body">
						<div class="text-center titulo-herbalife">Tomar pedido</div>
						<div class="row">
							<div class="col-md-4">
							 	<div class="form-group">
							 		<label class="control-label">Código asociado</label>
							 		<input type="text" name="codigo" class="form-control" v-model="asociado" ref="asoc">
							 	</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-primary form-control" v-on:click="search()">Buscar</button>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
							 		<label class="control-label">Nombre asociado</label>
							 		<input type="text" name="nombre" class="form-control" disabled="true" v-model="nombre">
							 	</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Código producto</label>
									<input type="text" name="no" v-model="buscar" class="form-control" ref="art">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-success form-control" v-on:click="buscar_producto()">Buscar</button>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">Nombre del producto</label>
									<input type="text" name="producto" class="form-control" disabled="true" v-model="articulo.nombre">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Cantidad</label>
									<input type="text" name="cantidad" class="form-control" v-model="cantidad" ref="input2" placeholder="cantidad">
								</div>
							</div>
							<div class="col-md-2" v-if="selectedItem">
								<div class="form-group">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-primary form-control" v-on:click="addRow()">Agregar</button>
								</div>
							</div>
						</div>
						<!-- Start detail -->
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="custom-table">
											<th width="5%">Código</th>
											<th>Producto</th>
											<th width="10%">PV</th>
											<th width="15%">Precio</th>
											<th width="5%">Cantidad</th>
											<th width="15%">Subtotal</th>
											<th width="5%"></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(item,index) in itemList">
											<td><span v-text="item.codigo"></span></td>
											<td><span v-text="item.nombre"></span></td>
											<td><span v-text="item.pv"></span></td>
											<td>Q. <span v-text="item.precio"></span></td>
											<td><span v-text="item.cantidad"></span></td>
											<td>Q. <span v-text="item.subtotal"></span></td>
											<td><button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar fila" v-on:click="removeRow(index)"><i class="glyphicon glyphicon-trash"></i></button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- End detail -->
						<!-- Start total -->
						<div class="row">
							<div class="col-md-12">
								<h4 class="pull-right">Total: Q. <span  v-text="formatPrice(total)"></span></h4>
							</div>
							<div class="col-md-12">
								<h4 class="pull-right">Descuento: <span v-text="formatDiscount(descuento)"></span></h4>
							</div>
							<div class="col-md-12">
								<h4 class="pull-right">Total pedido: Q. <span v-text="formatPrice(total_pedido)"></span></h4>
							</div>
						</div>
						<!-- End total -->
						<!-- Start Button send -->
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-primary btn-block btn-lg" @click="save">Guardar registro</button>
							</div>
						</div>
						<!-- End Button send -->
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

export default {

	props:{
		title: {
	        default: 'Ingrese el nombre del producto...',
	        type: String
	      },
	},

	data(){
		return{
			loading: false,

			asociado: 0,
			descuento: 0,
			nombre:'',
			asociado_id:0,
			dias:0,
			total_pedido: 0,
			pv_total:0,

			buscar: 0,
			articulo: {},
			total:0.00,
			itemList: [],
			cantidad: '',

			selectedItem: null,
			fila: {},

		};
	},

	mounted()
	{
		this.$refs.asoc.focus();
	},

	methods:{
		save(){
			if(this.itemList.length > 0){
				let data = {'monto':this.total_pedido,'pv_acumulado':this.pv_total,'asociado_id':this.asociado_id,'descuento':this.descuento,'dias':this.dias,'detalle':this.itemList};

				this.loading = true;

				axios.post('/pedidos',data)
				.then(response =>{
					this.clear();
					this.loading = false;
					toastr.success(response.data.data,'');	
				})
				.catch(error =>{
					this.loading = false;
					if (error.response) {
						toastr.error(error.response.data.error,'');	
				    }
				});
			}
			else
			{
				toastr.info('Debe generar registro con datos válidos','');
			}
		},

		clear()
		{
			this.itemList = [];
			this.asociado = 0;
			this.descuento = 0;
			this.nombre ='';
			this.asociado_id =0;
			this.dias =0;
			this.total_pedido = 0;
			this.pv_total =0;

			this.buscar = 0;
			this.articulo = {};
			this.total =0.00;
		},

		   buscar_producto()
		   {
		   	 if(this.buscar > 0){
		   	 	    this.loading = true;

				     axios.get('/pedidos-producto/'+ this.buscar).then(response => {

				     	this.articulo = {};
				      	this.loading = false;
				      	if(response.data.data)
				      	{				      		
				      		this.articulo = response.data.data;
				      		this.selectedItem = this.articulo;
				      	}
				      	else
				      	{
				      		toastr.error('No se encontró ningún producto asociado a ese código');
				      	}
				      	
				     })
				     .catch(error =>{
							this.loading = false;
							if (error.response) {
								toastr.error(error.response.data.error,'');	
						    }
						});
			  }
			  else
			  {
			  	toastr.info('Ingrese un código de producto válido','');
			  }
		   },

		  search(){
		  	 if(this.asociado > 0){
		  	 		this.loading = true;

				     axios.get('/pedidos-asociado/'+ this.asociado).then(response => {
				      	this.loading = false;

				      	if(response.data.data)
				      	{				      		
				      		this.nombre = response.data.data.nombres;
				      		this.asociado_id = response.data.data.id;
				      		this.descuento = response.data.data.descuento;
				      		this.dias = response.data.data.dias;
				      	}
				      	else
				      	{
				      		this.nombre = '';
				      		this.asociado_id = 0;
				      		this.descuento = 0;
				      		this.dias = 0;

				      		toastr.error('No se encontró ningún registro asociado a ese código');

				      	}
				      	
				     })
				     .catch(error =>{
							this.loading = false;
							if (error.response) {
								toastr.error(error.response.data.error,'');	
						    }
						});;
			  }
			  else
			  {
			  	toastr.info('Ingrese un código de asociado válido','');
			  }
		  },

		  formatPrice(value) {
		        return  (value).toFixed(2);		        
		  },

		  formatDiscount(value) {
		        return  value + '%';		        
		  },
		  formatTotal()
		  {
		  	 this.total_pedido = this.total - ((this.total * this.descuento)/100);
		  },

	      // Start driver of table

	      addRow(){
	      	 
	      	if(this.cantidad > 0){
	      		if(this.asociado_id > 0)
	      		{
	      			this.fila.id = this.articulo.id;
		      		this.fila.codigo = this.articulo.codigo;
		      		this.fila.precio = this.articulo.precio;
		      		this.fila.pv = this.articulo.pv;
			      	this.fila.nombre = this.articulo.nombre;
			      	this.fila.cantidad = parseInt(this.cantidad);
			      	this.fila.pv_acum = this.articulo.pv * parseInt(this.cantidad);
			      	this.fila.subtotal = this.articulo.precio * parseInt(this.cantidad);
			      	this.pv_total += this.fila.pv_acum;		      	
			      	this.itemList.push( this.fila); 	

			      	//total
			      	this.total += this.fila.subtotal;
			      	//descuento
			      	this.formatTotal(); 		   
				    this.fila = {};
				    this.articulo = {};
				    this.buscar = 0;
				    this.selectedItem= null;	        		
					this.cantidad= '';

					this.$refs.art.focus();
	      		}
	      		else
	      		{
	      			toastr.error('Por favor seleccione un asociado','');
	      		}

	      	}else{
	      		toastr.error('La cantidad es requerida','');	      		
	      	}
	      	
			   
			},

			removeRow(index){
				this.pv_total -= this.itemList[index].pv_acum;
				this.total -= this.itemList[index].subtotal;
				this.formatTotal();
			   this.itemList.splice(index, 1);
			}
	}
  	
}
</script>

<style type="text/css">
.close {
    position: absolute;
    right: 20px;
    top: 4px;
    background: none;
    border: none;
    font-size: 20px;
    color: #0a0a0a;
    cursor: pointer;
}
.placeholder {
    position: absolute;
    top: 7px;
    left: 27px;
    font-size: 14px;
    color: #989090;
    pointer-events: none;
}

.options {
    max-height: 150px;
    overflow-y: scroll;
    margin-top: 5px;
}
.options ul {
    list-style-type: none;
    text-align: left;
    padding-left: 0;
}
.options ul li {
    border-bottom: 1px solid lightgray;
    padding: 10px;
    cursor: pointer;
    background: #f1f1f1;
}
.options ul li:first-child {
    border-top: 2px solid #d6d6d6;
}

.options ul li:not(.selected):hover {
    background: #8c8c8c;
    color: #fff;
}
.options ul li.selected {
    background: #58bd4c;
    color: #fff;
    font-weight: 600;
}
</style>