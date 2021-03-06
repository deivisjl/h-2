<?php

namespace App\Http\Controllers\Reporte;

use App\Producto;
use App\Categoria;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
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
                    ->groupBy('asociado.id','asociado.nombres','asociado.apellidos','tipo_asociado.nombre')
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
                    ->groupBy('asociado.id','asociado.nombres','asociado.apellidos','tipo_asociado.nombre')                    
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
        $ordenadores = array("categoria.id","producto.nombre","categoria.nombres");

        $columna = $request['order'][0]["column"];        
        $categoria = $request['buscar'][0]["categoria"];
        $fecha_desde = $request['buscar'][0]["fecha_desde"];
        $fecha_hasta = $request['buscar'][0]["fecha_hasta"];
        
        $criterio = $request['search']['value'];

        $categorias = DB::table('pedido')
                    ->join('detalle_pedido','pedido.id','=','detalle_pedido.pedido_id')
                    ->join('producto','detalle_pedido.producto_id','=','producto.id')
                    ->join('categoria','producto.categoria_id','categoria.id')
                    ->select('categoria.id','producto.id','producto.nombre  as producto','categoria.nombre as categoria',DB::raw('SUM(detalle_pedido.importe) as monto'))
                    ->where('categoria.id','=',$categoria)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->groupBy('categoria.id','producto.id','producto.nombre','categoria.nombre')
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('pedido')
                    ->join('detalle_pedido','pedido.id','=','detalle_pedido.pedido_id')
                    ->join('producto','detalle_pedido.producto_id','=','producto.id')
                    ->join('categoria','producto.categoria_id','categoria.id')
                    ->select('categoria.id','producto.id','producto.nombre','categoria.nombre',DB::raw('SUM(detalle_pedido.importe) as monto'))
                    ->where('categoria.id','=',$categoria)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->groupBy('categoria.id','producto.id','producto.nombre','categoria.nombre')
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
    public function pedido(Request $request)
    {
         $ordenadores = array("asociado.id","asociado.nombres","tipo_asociado.nombre","pedido.id","pedido.total");

        $columna = $request['order'][0]["column"];        
        $asociado = $request['buscar'][0]["asociado"];
        $fecha_desde = $request['buscar'][0]["fecha_desde"];
        $fecha_hasta = $request['buscar'][0]["fecha_hasta"];
        
        $criterio = $request['search']['value'];

        $count = DB::table('asociado')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->join('pedido','asociado.id','=','pedido.asociado_id')
                    
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','pedido.total','tipo_asociado.nombre as tipo',DB::raw('date_format(pedido.created_at,"%d-%m-%Y") as fecha'))
                    ->where('asociado.id','=',$asociado)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->count();

        $asociado = DB::table('asociado')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->join('pedido','asociado.id','=','pedido.asociado_id')
                    
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','pedido.total','tipo_asociado.nombre as tipo',DB::raw('date_format(pedido.created_at,"%d-%m-%Y") as fecha'))
                    ->where('asociado.id','=',$asociado)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('pedido.created_at', [$fecha_desde, $fecha_hasta." 23:59:59"])
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $asociado,
        );

        return response()->json($data, 200);
    }

    public function imprimir_fecha(Request $request)
   {
        try 
        {

        $reporte_fecha = DB::table('pedido')
                    ->join('asociado','pedido.asociado_id','=','asociado.id')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),DB::raw('SUM(pedido.total) as monto'),'tipo_asociado.nombre as tipo')
                    ->whereBetween('pedido.created_at', [$request->get('desde'), $request->get('hasta')." 23:59:59"])
                    ->groupBy('asociado.id','asociado.nombres','asociado.apellidos','tipo_asociado.nombre')
                    ->get();

    $pdf = \PDF::loadView('reporte.imprimir.reporte-fecha-imprimir',['reporte_fecha' => $reporte_fecha,'desde'=> $request->get('desde'),'hasta'=>$request->get('hasta')]);

             $pdf->setPaper('letter', 'portrait');
            
             return $pdf->download('reporte_fechas_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error',$e->getMessage()],422);
        }
   }

   public function imprimir_categoria(Request $request)
   {
        try 
        {

       $reporte_categoria = DB::table('pedido')
                    ->join('detalle_pedido','pedido.id','=','detalle_pedido.pedido_id')
                    ->join('producto','detalle_pedido.producto_id','=','producto.id')
                    ->join('categoria','producto.categoria_id','categoria.id')
                    ->select('categoria.id','producto.id','producto.nombre as producto','categoria.nombre as categoria',DB::raw('SUM(detalle_pedido.importe) as monto'))
                    ->where('categoria.id','=',$request->get('categoria'))
                    ->whereBetween('pedido.created_at', [$request->get('desde'), $request->get('hasta')." 23:59:59"])
                    ->groupBy('categoria.id','producto.id','producto.nombre','categoria.nombre')
                    ->get();

    $pdf = \PDF::loadView('reporte.imprimir.reporte-categoria-imprimir',['reporte_categoria' => $reporte_categoria,'desde'=> $request->get('desde'),'hasta'=>$request->get('hasta')]);

             $pdf->setPaper('letter', 'portrait');
            
             return $pdf->download('reporte_categorias_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error',$e->getMessage()],422);
        }
   }

   public function imprimir_asociado(Request $request)
   {
        try 
        {

            $asociado = DB::table('asociado')
                    ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                    ->join('pedido','asociado.id','=','pedido.asociado_id')
                    
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','pedido.total','tipo_asociado.nombre as tipo',DB::raw('date_format(pedido.created_at,"%d-%m-%Y") as fecha'))
                    ->where('asociado.id','=',$request->get('asociado'))
                    ->whereBetween('pedido.created_at', [$request->get('desde'), $request->get('hasta')." 23:59:59"])
                    ->get();

        $pdf = \PDF::loadView('reporte.imprimir.reporte-asociado-imprimir',
                    ['asociado' => $asociado,'desde'=> $request->get('desde'),'hasta'=>$request->get('hasta')]);

             $pdf->setPaper('letter', 'portrait');
            
             return $pdf->download('reporte_asociado_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error',$e->getMessage()],422);
        }
   }
}
