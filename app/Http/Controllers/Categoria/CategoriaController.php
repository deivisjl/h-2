<?php

namespace App\Http\Controllers\Categoria;

use App\Producto;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoria.create');
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

        $categoria = new Categoria($request->all());
        //$categoria->nombre = $request->get('nombre');
        $categoria->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/categorias');
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


        $categorias = DB::table('categoria')              
                ->select('id','nombre') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('categoria')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('admin.categoria.edit',['categoria' => $categoria]);
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

        $categoria =  Categoria::findOrFail($id);
        $categoria->nombre = $request->get('nombre');
        $categoria->save();

        Flash::success('','El registro se actualizó con éxito');

        return redirect('/categorias');
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
            $categoria = Categoria::findOrFail($id);

            $relacion = Producto::where('categoria_id','=',$categoria->id)->count();

            if($relacion > 0)
            {
                throw new \Exception("No es posible eliminar porque tiene registros asociados");
                
            }

            $categoria->delete();

            return response()->json(['data' => 'El registro se ha eliminado con éxito'],200);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }
}
