<?php

namespace App\Http\Controllers\Comision;

use App\Comision;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('comision.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("comision.asociado_id","asociado.nombres","comision.monto","comision.created_at");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $comision = DB::table('comision')  
                ->join('asociado','comision.asociado_id','=','asociado.id')            
                ->select('comision.asociado_id as id', DB::raw('CONCAT_WS(" ",asociado.nombres," ",asociado.apellidos) as nombre'),DB::raw('SUM(comision.monto) as monto')) 
                ->where('comision.estado','=',1)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->groupBy('comision.asociado_id','asociado.nombres','asociado.apellidos')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('comision')  
                ->join('asociado','comision.asociado_id','=','asociado.id')
                ->where('comision.estado','=',1)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->groupBy('comision.asociado_id','asociado.nombres','asociado.apellidos')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $comision,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try 
        {
            $comision = null;

            DB::beginTransaction();

            $comisiones = Comision::where('asociado_id','=',$id)
                                    ->where('estado','=',1)
                                    ->get();

            if($comisiones->count() > 0)
            {
                $comision = DB::table('comision')
                            ->join('asociado','comision.asociado_id','=','asociado.id')
                            ->select('asociado.id',DB::raw('SUM(comision.monto) as monto'),DB::raw('CONCAT_WS(" ",asociado.nombres," ",asociado.apellidos) as nombre'))
                            ->where('comision.estado','=',1)
                            ->where('asociado.id','=',$id)
                            ->groupBy('comision.asociado_id','asociado.nombres','asociado.apellidos')
                            ->first();

            }

            $fecha = Carbon::now()->format('d-m-Y');

             $pdf = \PDF::loadView('comision.imprimir',['comision' => $comision,'fecha' => $fecha]);

             $pdf->setPaper('half-letter', 'landscape');

             foreach ($comisiones as $key => $comision) 
                {
                    $comision->estado = 0;
                    $comision->save();    
                }

             DB::commit();
            
             return $pdf->download('pago_'.Carbon::now()->format('dmY_h:m:s').'.pdf');
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            return response()->json(['error',$e->getMessage()],422);
        }
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
        //
    }
}
