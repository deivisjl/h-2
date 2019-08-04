<?php

namespace App\Http\Controllers\Pais;

use App\Pais;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pais.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pais.create');
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
              'nombre' => 'required|string|max:100'
            ];            

        $this->validate($request, $rules);

        $pais = new Pais();
        $pais->nombre = $request->get('nombre');
        $pais->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/paises');
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


        $paises = DB::table('pais')              
                ->select('id','nombre') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('pais')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $paises,
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
        $pais = Pais::findOrFail($id);

        return view('admin.pais.edit',['pais' => $pais]);
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
              'nombre' => 'required|string|max:100'
            ];            

        $this->validate($request, $rules);

        $pais = Pais::findOrFail($id);
        $pais->nombre = $request->get('nombre');
        $pais->save();

        Flash::success('','El registro se editó con éxito');

        return redirect('/paises');

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
            $pais = Pais::findOrFail($id);

            $relacion = Departamento::where('pais_id','=',$pais->id)->count();

            if($relacion > 0)
            {
                throw new \Exception("No es posible eliminar porque tiene registros asociados");
                
            }

            $pais->delete();

            return response()->json(['data' => 'El registro se ha eliminado con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }
}
