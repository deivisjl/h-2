<?php

namespace App\Http\Controllers\Inicio;

use App\Producto;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = DB::table('categoria')
                        ->join('producto','categoria.id','=','producto.categoria_id')
                        ->select('categoria.id','categoria.slug','categoria.nombre',DB::raw('COUNT(producto.id) as total'))
                        ->groupBy('categoria.id','categoria.slug','categoria.nombre')
                        ->get();

        $productos = Producto::all();

        return view('welcome',['categorias' => $categorias,'productos' => $productos ]);
    }

    public function detalle($id)
    {
        $categorias = DB::table('categoria')
                        ->join('producto','categoria.id','=','producto.categoria_id')
                        ->select('categoria.id','categoria.slug','categoria.nombre',DB::raw('COUNT(producto.id) as total'))
                        ->groupBy('categoria.id','categoria.slug','categoria.nombre')
                        ->get();

        $producto = Producto::findOrFail($id);

        return view('product-detail',['categorias' => $categorias,'producto' => $producto]);        
    }

    public function categoria($slug)
    {
        $categorias = DB::table('categoria')
                        ->join('producto','categoria.id','=','producto.categoria_id')
                        ->select('categoria.id','categoria.slug','categoria.nombre',DB::raw('COUNT(producto.id) as total'))
                        ->groupBy('categoria.id','categoria.slug','categoria.nombre')
                        ->get();
        
        $categoria = Categoria::findBySlugOrFail($slug);

        $productos = $categoria->producto()->get();

        $productos->each(function($productos){
            $productos->categoria;
        });

        return view('welcome',['categorias' => $categorias,'productos' => $productos ]);
    }
}
