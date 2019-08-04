<?php

namespace App\Http\Controllers\Departamento;

use App\Pais;
use App\Municipio;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function inicio($id)
    {
        $pais = Pais::findOrFail($id);

        return view('admin.departamento.index',['pais' => $pais]);
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

    public function registrar($id)
    {
        $pais = Pais::findOrFail($id);

        return view('admin.departamento.create',['pais' => $pais]);
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
              'pais' => 'required|numeric|min:1',
              'nombre' => 'required|string|max:100'
            ];            

        $this->validate($request, $rules);

        $departamento = new Departamento();
        $departamento->pais_id = $request->get('pais');
        $departamento->nombre = $request->get('nombre');
        $departamento->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/pais-departamento/'.$departamento->pais_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];

         $pais = $request['buscar'][0]['id'];


        $departamentos = DB::table('departamento')              
                ->select('id','nombre') 
                ->where('pais_id','=', $pais)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('departamento')
                ->where('pais_id','=', $pais)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $departamentos,
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
        $departamento = Departamento::findOrFail($id);

        return view('admin.departamento.edit',['departamento' => $departamento]);
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
              'pais' => 'required|numeric|min:1',
              'nombre' => 'required|string|max:100'
            ];            

        $this->validate($request, $rules);

        $departamento = Departamento::findOrFail($id);
        $departamento->pais_id = $request->get('pais');
        $departamento->nombre = $request->get('nombre');
        $departamento->save();

        Flash::success('','El registro se actualizó con éxito');

        return redirect('/pais-departamento/'.$departamento->pais_id);
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
            $departamento = Departamento::findOrFail($id);

            $relacion = Municipio::where('departamento_id','=',$departamento->id)->count();

            if($relacion > 0)
            {
                throw new \Exception("No es posible eliminar porque tiene registros asociados");
                
            }

            $departamento->delete();

            return response()->json(['data' => 'El registro se ha eliminado con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }
}
