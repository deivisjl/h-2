<?php

namespace App\Http\Controllers\Reporte;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteAsociadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reporte.asociado');
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reporte(Request $request)
    {
         $ordenadores = array("asociado.id","asociado.nombres","tipo_asociado.nombre");

        $columna = $request['order'][0]["column"];        
        $asociado = $request['buscar'][0]["asociado"];
        $desde = $request['buscar'][0]["date_from"];
        $hasta = $request['buscar'][0]["date_until"];
        
        $criterio = $request['search']['value'];

        $comisiones = DB::table('users')
                    ->join('asociado','users.id','=','asociado.usuario_id')
                    ->join('comision','asociado.id','=','comision.asociado_id')
                    ->join('pedido','comision.pedido_id','=','pedido.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','comision.monto',DB::raw('date_format(comision.created_at,"%d-%m-%Y") as fecha'))
                    ->where('users.id','=',$asociado)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('comision.created_at', [$desde, $hasta." 23:59:59"])
                    ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                    ->skip($request['start'])
                    ->take($request['length'])
                    ->get();

        $count = DB::table('users')
                    ->join('asociado','users.id','=','asociado.usuario_id')
                    ->join('comision','asociado.id','=','comision.asociado_id')
                    ->join('pedido','comision.pedido_id','=','pedido.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','comision.monto',DB::raw('date_format(comision.created_at,"%d-%m-%Y") as fecha'))
                    ->where('users.id','=',$asociado)
                    ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                    ->whereBetween('comision.created_at', [$desde, $hasta." 23:59:59"])
                    ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $comisiones,
        );

        return response()->json($data, 200);
    }

    public function imprimir(Request $request)
    {
        try 
        {

            $comisiones = DB::table('users')
                    ->join('asociado','users.id','=','asociado.usuario_id')
                    ->join('comision','asociado.id','=','comision.asociado_id')
                    ->join('pedido','comision.pedido_id','=','pedido.id')
                    ->select('asociado.id',DB::raw('CONCAT(asociado.nombres," ",asociado.apellidos) as asociado'),'pedido.id as pedido','comision.monto',DB::raw('date_format(comision.created_at,"%d-%m-%Y") as fecha'))
                    ->where('users.id','=',$request->get('asociado'))
                    ->whereBetween('comision.created_at', [$request->get('desde'), $request->get('hasta')." 23:59:59"])
                    ->get();

        $pdf = \PDF::loadView('reporte.imprimir-reporte-asociado',['comisiones' => $comisiones,'desde'=> $request->get('desde'),'hasta'=>$request->get('hasta')]);

             $pdf->setPaper('letter', 'portrait');
            
             return $pdf->download('reporte_asociado_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error',$e->getMessage()],422);
        }
    }   
}
