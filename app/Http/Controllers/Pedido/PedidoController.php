<?php

namespace App\Http\Controllers\Pedido;

use App\Pedido;
use App\Asociado;
use App\Comision;
use App\Producto;
use Carbon\Carbon;
use App\TipoAsociado;
use App\DetallePedido;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pedido.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pedido.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            $datos = $request->all();

            $importe = (($request->get('monto') * 100)/(100-$request->get('descuento')));
            $parcial = ($importe * $request->get('descuento'))/100;

            DB::beginTransaction();

            $pedido = new Pedido();
            $pedido->monto = $request->get('monto');
            $pedido->pv_acumulado = $request->get('pv_acumulado');
            $pedido->asociado_id = $request->get('asociado_id');
            $pedido->porcentaje = $request->get('descuento');
            $pedido->total = $importe;
            $pedido->descuento = $parcial;
            $pedido->estado = 1;
            $pedido->usuario_id = Auth::user()->id;
            $pedido->save();

            foreach ($datos['detalle'] as $key => $value) 
            {
                $detalle = new DetallePedido();
                $detalle->pedido_id = $pedido->id;
                $detalle->producto_id = $value['id'];
                $detalle->cantidad = $value['cantidad'];
                $detalle->codigo = $value['codigo'];
                $detalle->importe = $value['subtotal'];
                $detalle->precio = $value['precio'];
                $detalle->pv = $value['pv'];
                $detalle->save();
            }

            DB::commit();

            return response()->json(['data' => 'Pedido generado con éxito'],200);    
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("pedido.id","asociado.nombres","pedido.monto","pedido.pv_acumulado","pedido.created_at","pedido.estado");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $pedidos = DB::table('pedido')  
                ->join('asociado','pedido.asociado_id','=','asociado.id')            
                ->select('pedido.id','pedido.monto','pedido.pv_acumulado','pedido.estado',DB::raw('CONCAT_WS(" ",asociado.nombres," ",asociado.apellidos) as asociado'),DB::raw('date_format(pedido.created_at,"%Y-%m-%d") as fecha')) 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('pedido')
                ->join('asociado','pedido.asociado_id','=','asociado.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $pedidos,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imprimir($id)
    {
        try 
        {
                
             $pedido = Pedido::findOrFail($id);

             if($pedido->estado > 0)
             {

                $result = $this->verificar_tipo($pedido);

                 if($result)
                 {
                    $resp = $this->calcular_pedidos($pedido->asociado, $result ,$pedido->created_at);
                    
                    if($resp > 0)
                    {
                        $asoc = Asociado::findOrFail($pedido->asociado_id);
                        $asoc->tipo_asociado_id = $resp;
                        $asoc->save();
                    }
                 }

                    $comision = new Comision();
                    $comision->pedido_id = $pedido->id;
                    $comision->asociado_id = $pedido->asociado->id;
                    $comision->patrocinado_id = $pedido->asociado->patrocinador_id;
                    $comision->monto = $pedido->descuento;
                    $comision->estado = 1;
                    $comision->save();

                    if($pedido->asociado_id != $pedido->asociado->patrocinador_id)
                    {
                        $comision = new Comision();
                        $comision->pedido_id = $pedido->id;
                        $comision->asociado_id = $pedido->asociado->patrocinador_id;
                        $comision->patrocinado_id = $pedido->asociado->id;
                        $comision->monto = $pedido->descuento;
                        $comision->estado = 1;
                        $comision->save();
                    }

                 $pedido->estado = 0;
                 $pedido->save();
             }

             $detalle = DetallePedido::where('pedido_id','=',$pedido->id)->get();

             $pdf = \PDF::loadView('pedido.imprimir',['pedido' => $pedido,'detalle' => $detalle]);

             $pdf->setPaper('letter', 'portrait');
            
             return $pdf->download('factura_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);    
        }
    }

    public function verificar_tipo($pedido)
    {
        $candidato = null;

        $tipos = TipoAsociado::orderBy('descuento','asc')->get();

        $desc_actual = $pedido->asociado->tipo_asociado->descuento;

        foreach ($tipos as $key => $value) 
        {
            if($value->descuento > $desc_actual)
            {
                $candidato = $value;
                break;
            }    
        }

        return $candidato;
    }

    public function calcular_pedidos($asociado, $tipo, $fecha)
    {
        $id = 0;

        $inicio = Carbon::now()
                    ->subDays($tipo->dias)
                    ->format('Y-m-d');

        $fin = Carbon::parse($fecha)->format('Y-m-d');

        $puntos = DB::table('pedido')
                    ->select(DB::raw('SUM(pv_acumulado) as acumulado'))
                    ->where('asociado_id','=',$asociado->id)
                    ->whereBetween('created_at',[$inicio.' 00:00:00', $fin.' 23:59:59'])
                    ->first();

        if($puntos->acumulado >= $tipo->pv)
        {
            $id = $tipo->id;
        }   

        return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            DB::beginTransaction();

            $pedido = Pedido::findOrFail($id);

            if($pedido->estado == 0)
            {
                throw new \Exception("Este pedido ya ha sido procesado");
                
            }

            $detalles = DetallePedido::where('pedido_id','=',$pedido->id)->get();

            foreach ($detalles as $key => $value) {
                $value->delete();
            }

            $pedido->delete();

            DB::commit();

            return response()->json(['data' => 'El registro se eliminó con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()],422);      
        }
    }

    public function producto($id)
    {
        try 
        {
             $producto = Producto::where('codigo','=',$id)->first();   
             return response()->json(['data' => $producto],200);   
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);   
        }
    }

    public function asociado($id)
    {
        try 
        {
            $asociado = DB::table('asociado')
                        ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')
                        ->select('asociado.id',DB::raw('CONCAT_WS(" ",asociado.nombres," ",asociado.apellidos) as nombres'),'tipo_asociado.descuento','tipo_asociado.dias')
                        ->where('asociado.id','=',$id)
                        ->first();

            return response()->json(['data' => $asociado],200);    
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);           
        }
    }
}
