<?php

namespace App\Http\Controllers\Municipio;

use App\Municipio;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class MunicipioController extends Controller
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
        $departamento = Departamento::findOrFail($id);

        return view('admin.municipio.index',['departamento' => $departamento]);
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
        $departamento = Departamento::findOrFail($id);

        return view('admin.municipio.create',['departamento' => $departamento]);
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
              'departamento' => 'required|numeric|min:1',
              'nombre' => 'required|string|max:100'
            ];            

        $this->validate($request, $rules);

        $municipio = new Municipio();
        $municipio->departamento_id = $request->get('departamento');
        $municipio->nombre = $request->get('nombre');
        $municipio->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/departamento-municipio/'.$municipio->departamento_id);
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

        $departamento = $request['buscar'][0]['id'];


        $municipios = DB::table('municipio')              
                ->select('id','nombre') 
                ->where('departamento_id','=', $departamento)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('municipio')
                ->where('departamento_id','=', $departamento)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $municipios,
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
        $municipio = Municipio::findOrFail($id);

        return view('admin.municipio.edit',['municipio' => $municipio]);
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

        $municipio = Municipio::findOrFail($id);        
        $municipio->nombre = $request->get('nombre');
        $municipio->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/departamento-municipio/'.$municipio->departamento_id);
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
