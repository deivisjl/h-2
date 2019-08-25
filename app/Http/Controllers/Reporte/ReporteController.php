<?php

namespace App\Http\Controllers\Reporte;

use App\Producto;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();

        return view('reporte.index',['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fecha(Request $request)
    {
        $ordenadores = array("asociado.id","asociado.nombres","tipo_asociado.nombre");

        $columna = $request['order'][0]["column"];        
        $desde = $request['buscar'][0]["date_from"];
        $hasta = $request['buscar'][0]["date_until"];
        
        $criterio = $request['search']['value'];

        $ventas = DB::table('pedido')
                    ->join('asociado','pedido.asociado_id','=','asociado.id')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),DB::raw('SUM(pedido.total) as monto'),'tipo_asociado.nombre as tipo')
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$desde, $hasta." 23:59:59"])
                    ->groupBy('asociado.id','tipo_asociado.nombre')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('pedido')
                    ->join('asociado','pedido.asociado_id','=','asociado.id')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),DB::raw('SUM(pedido.total) as monto','tipo_asociado.nombre'))
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$desde, $hasta." 23:59:59"])
                    ->groupBy('asociado.id','tipo_asociado.nombre')                    
                    ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $ventas,
        );

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categoria(Request $request)
    {
        $ordenadores = array("categoria.id","categoria.nombres");

        $columna = $request['order'][0]["column"];        
        $categoria = $request['buscar'][0]["categoria"];
        $fecha_desde = $request['buscar'][0]["fecha_desde"];
        $fecha_hasta = $request['buscar'][0]["fecha_hasta"];
        
        $criterio = $request['search']['value'];

        $categorias = DB::table('pedido')
                    ->join('detalle_pedido','pedido.id','=','detalle_pedido.pedido_id')
                    ->join('producto','detalle_pedido.producto_id','=','producto.id')
                    ->join('categoria','producto.categoria_id','categoria.id')
                    ->select('categoria.id','producto.id','categoria.nombre as categoria',DB::raw('SUM(detalle_pedido.importe) as monto'))
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->groupBy('categoria.id','producto.id','categoria.nombre')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('pedido')
                    ->join('detalle_pedido','pedido.id','=','detalle_pedido.pedido_id')
                    ->join('producto','detalle_pedido.producto_id','=','producto.id')
                    ->join('categoria','producto.categoria_id','categoria.id')
                    ->select('categoria.id','producto.id','categoria.nombre',DB::raw('SUM(detalle_pedido.importe) as monto'))
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->groupBy('categoria.id','producto.id','categoria.nombre')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $categorias,
        );

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
