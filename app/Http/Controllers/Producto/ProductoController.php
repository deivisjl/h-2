<?php

namespace App\Http\Controllers\Producto;

use App\Producto;
use App\Categoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use HepplerDotNet\FlashToastr\Flash;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.producto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();

        return view('admin.producto.create',['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file()) {
            $file = $request->file('imagen');
            $ruta = '/img/productos/';
            $name =  sha1(Carbon::now()).'.'.$file->guessExtension();

            $file->move(getcwd().$ruta, $name);
        }

        $rules = [
            'codigo' => 'required|numeric|min:1|unique:producto',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:1',
            'puntos' => 'required|numeric|min:1',
            'descripcion' => 'required|string',
            'categoria' => 'required|numeric|min:1'
        ];

        $this->validate($request, $rules);

        $producto = new Producto();
        $producto->codigo = $request->get('codigo');
        $producto->nombre = $request->get('nombre');
        $producto->precio = $request->get('precio');
        $producto->pv = $request->get('puntos');
        $producto->descripcion = $request->get('descripcion');
        $producto->categoria_id = $request->get('categoria');
        $producto->img_url = $ruta.$name;
        $producto->save();

        Flash::success('','El registro se guardó con éxito');

        return redirect('/productos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("producto.id","producto.codigo","producto.nombre","producto.precio","producto.pv","producto.img_url","categoria.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $productos = DB::table('producto')             
                ->join('categoria','producto.categoria_id','=','categoria.id') 
                ->select('producto.id','producto.codigo','producto.nombre','producto.precio','producto.pv','producto.img_url','categoria.nombre as categoria') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('producto')
                ->join('categoria','producto.categoria_id','=','categoria.id') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $productos,
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
        $categorias = Categoria::all();
        $producto = Producto::findOrFail($id);

        return view('admin.producto.edit',['categorias' => $categorias, 'producto' => $producto]);
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
            'codigo' => 'required|numeric|min:1',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:1',
            'puntos' => 'required|numeric|min:1',
            'descripcion' => 'required|string',
            'categoria' => 'required|numeric|min:1'
        ];

        $this->validate($request, $rules);

        $producto = Producto::findOrFail($id);
        $producto->codigo = $request->get('codigo');
        $producto->nombre = $request->get('nombre');
        $producto->precio = $request->get('precio');
        $producto->pv = $request->get('puntos');
        $producto->descripcion = $request->get('descripcion');
        $producto->categoria_id = $request->get('categoria');

        if($request->hasFile('imagen')){            

            $file = $request->file('imagen');

            $ruta = '/img/productos/';

            $name = sha1(Carbon::now()).'.'.$file->guessExtension();

            $file->move(getcwd().$ruta, $name);

            if($producto->img_url){

                $rutaanterior = getcwd().$producto->img_url;

                    if(file_exists($rutaanterior)){

                        unlink(realpath($rutaanterior));
                        
                    }
            }

            $producto->img_url = $ruta.$name;

        }

        $producto->save();

        Flash::success('','El registro se actualizó con éxito');

        return redirect('/productos');
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
            $producto = Producto::findOrFail($id);

            if($producto->img_url){

                $rutaanterior = getcwd().$producto->img_url;

                    if(file_exists($rutaanterior)){

                        unlink(realpath($rutaanterior));
                        
                    }
            }

            $producto->delete();

            return response()->json(['data' => 'El registro se eliminó con éxito']);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()],422);
        }
    }
}
