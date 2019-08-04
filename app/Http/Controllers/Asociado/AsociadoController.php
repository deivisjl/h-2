<?php

namespace App\Http\Controllers\Asociado;

use App\Pais;
use App\Asociado;
use App\Municipio;
use App\Departamento;
use App\TipoAsociado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class AsociadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asociado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Pais::orderBy('nombre','asc')->get();
        $tipos = TipoAsociado::orderBy('orden','asc')->get();

        return view('asociado.create',['paises'=>$paises,'tipos' => $tipos]);
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
              'nombres' => 'required|string|max:100',
              'apellidos' => 'required|string|max:100',
              'dpi' => 'required|numeric|min:1|unique:asociado',
              'telefono' => 'required|numeric|min:1',
              'correo_electronico' => 'required|email',
              'tipo_asociado' => 'required|numeric|min:1',
              'municipio' => 'required|numeric|min:1',
              'patrocinador' => 'nullable|numeric',
              'direccion' => 'required|string'
            ];            

        $this->validate($request, $rules);

        $asociado = new Asociado();
        $asociado->nombres = $request->get('nombres');
        $asociado->apellidos = $request->get('apellidos');
        $asociado->dpi = $request->get('dpi');
        $asociado->telefono = $request->get('telefono');
        $asociado->correo = $request->get('correo_electronico');
        $asociado->tipo_asociado_id = $request->get('tipo_asociado');
        $asociado->direccion = $request->get('direccion');
        $asociado->municipio_id = $request->get('municipio');        
        $asociado->save();

        $asociado->patrocinador_id = ($request->get('patrocinador') != 0) ? $request->get('patrocinador') : $asociado->id;
        $asociado->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/asociados');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("asociado.id","asociado.apellidos","asociado.nombres","asociado.dpi","asociado.direccion","asociado.telefono","asociado.correo","tipo_asociado.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $asociados = DB::table('asociado') 
                ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')             
                ->select('asociado.id','asociado.apellidos','asociado.nombres','asociado.dpi','asociado.direccion','asociado.telefono','asociado.correo','tipo_asociado.nombre as tipo') 
                ->whereNull('asociado.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('asociado')
                ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id')             
                ->whereNull('asociado.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $asociados,
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
        $tipos = TipoAsociado::orderBy('orden','asc')->get();
        $asociado = Asociado::findOrFail($id);

        return view('asociado.edit',['tipos' => $tipos,'asociado' => $asociado]);
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
              'nombres' => 'required|string|max:100',
              'apellidos' => 'required|string|max:100',
              'dpi' => 'required|numeric|min:1',
              'telefono' => 'required|numeric|min:1',
              'correo_electronico' => 'required|email',
              'tipo_asociado' => 'required|numeric|min:1',
              'direccion' => 'required|string'
            ];            

        $this->validate($request, $rules);

        $asociado = Asociado::findOrFail($id);
        $asociado->nombres = $request->get('nombres');
        $asociado->apellidos = $request->get('apellidos');
        $asociado->dpi = $request->get('dpi');
        $asociado->telefono = $request->get('telefono');
        $asociado->correo = $request->get('correo_electronico');
        $asociado->tipo_asociado_id = $request->get('tipo_asociado');
        $asociado->direccion = $request->get('direccion');
        $asociado->save();

        Flash::success('','El registro se actualizó con éxito');

        return redirect('/asociados');
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
            $asociado = Asociado::findOrFail($id);
            $asociado->delete();

            return response()->json(['data' => 'El registro se eliminó con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);    
        }
    }

    public function listar(Request $request)
    {
        $ordenadores = array("asociado.id","asociado.apellidos","asociado.nombres","asociado.dpi","asociado.telefono");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $asociados = DB::table('asociado')
                ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id') 
                ->select('asociado.id','asociado.apellidos','asociado.nombres','asociado.dpi','asociado.telefono')
                ->whereNull('asociado.deleted_at') 
                ->where('tipo_asociado.regalia','=',1)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('asociado')
                ->join('tipo_asociado','asociado.tipo_asociado_id','=','tipo_asociado.id') 
                ->whereNull('asociado.deleted_at')
                ->where('tipo_asociado.regalia','=',1)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $asociados,
        );

        return response()->json($data, 200);
    }

    public function departamento($id)
    {
        try 
        {
            $departamentos = Departamento::where('pais_id','=',$id)->orderBy('nombre','asc')->get();

            return response()->json(['data' => $departamentos],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }

    public function municipio($id)
    {
        try 
        {
            $municipios = Municipio::where('departamento_id','=',$id)->orderBy('nombre','asc')->get();
            
            return response()->json(['data' => $municipios],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }
}
