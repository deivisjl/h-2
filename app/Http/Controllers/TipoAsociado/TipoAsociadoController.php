<?php

namespace App\Http\Controllers\TipoAsociado;

use App\TipoAsociado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class TipoAsociadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tipo-asociado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipo-asociado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $rules = [
              'nombre' => 'required|string|max:100',
              'descuento' => 'required|numeric|min:1',
              'puntos' => 'required|numeric|min:0',
              'dias' => 'required|numeric|min:0',
              'orden' => 'required|numeric|min:1',
              'es_patrocinador' => 'required|numeric|min:0|max:1'
            ];            

        $this->validate($request, $rules);

        $tipo = new TipoAsociado();
        $tipo->nombre = $request->get('nombre');
        $tipo->descuento = $request->get('descuento');
        $tipo->pv = $request->get('puntos');
        $tipo->dias = $request->get('dias');
        $tipo->orden = $request->get('orden');
        $tipo->regalia = $request->get('es_patrocinador');
        $tipo->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/tipo-asociado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre","descuento","pv","dias","orden");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $tipos = DB::table('tipo_asociado')              
                ->select('id','nombre','descuento','pv','dias','orden','regalia') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('tipo_asociado')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $tipos,
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
        $tipo = TipoAsociado::findOrFail($id);

        return view('admin.tipo-asociado.edit',['tipo' => $tipo]);
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
        $rules = [
              'nombre' => 'required|string|max:100',
              'descuento' => 'required|numeric|min:1',
              'puntos' => 'required|numeric|min:0',
              'dias' => 'required|numeric|min:0',
              'orden' => 'required|numeric|min:1',
              'es_patrocinador' => 'required|numeric|min:0|max:1'
            ];            

        $this->validate($request, $rules);

        $tipo = TipoAsociado::findOrFail($id);
        $tipo->nombre = $request->get('nombre');
        $tipo->descuento = $request->get('descuento');
        $tipo->pv = $request->get('puntos');
        $tipo->dias = $request->get('dias');
        $tipo->orden = $request->get('orden');
        $tipo->regalia = $request->get('es_patrocinador');
        $tipo->save();

        Flash::success('','El registro se actualizó con éxito');

        return redirect('/tipo-asociado');
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
            $tipo = TipoAsociado::findOrFail($id);
            //

            $tipo->delete();

            return response()->json(['data' => 'El registro se eliminó con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);    
        }
    }
}
