<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Inicio\InicioController@index');
Route::get('/categoria/{slug}', 'Inicio\InicioController@categoria');
Route::get('/detalle-producto/{id}', 'Inicio\InicioController@detalle');

Route::get('/logout','Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['guest']], function() {

Route::name('credenciales')->get('registro/credencial/{token}','Asociado\AsociadoController@credencial');

});

Route::post('/cambiar-credencial','Asociado\AsociadoController@renovar_credencial');

//administrador
Route::group(['middleware' => ['auth','admin']], function() {

    Route::resource('paises','Pais\PaisController');

    Route::resource('departamentos','Departamento\DepartamentoController',['except'=>['index','create']]);
    Route::get('pais-departamento/{id}','Departamento\DepartamentoController@inicio');
    Route::get('departamento-registrar/{id}','Departamento\DepartamentoController@registrar');

    Route::resource('municipios','Municipio\MunicipioController',['except'=>['index','create']]);
    Route::get('departamento-municipio/{id}','Municipio\MunicipioController@inicio');
    Route::get('municipio-registrar/{id}','Municipio\MunicipioController@registrar');

    Route::resource('categorias','Categoria\CategoriaController');

    Route::resource('productos','Producto\ProductoController');

    Route::resource('tipo-asociado','TipoAsociado\TipoAsociadoController');

    Route::resource('asociados','Asociado\AsociadoController');
    Route::get('asociados-listar/{listar}','Asociado\AsociadoController@listar');
    Route::get('asociados-departamento/{id}','Asociado\AsociadoController@departamento');
    Route::get('asociados-municipio/{id}','Asociado\AsociadoController@municipio');

    Route::resource('pedidos','Pedido\PedidoController');
    Route::get('pedidos-asociado/{id}','Pedido\PedidoController@asociado');
    Route::get('pedidos-producto/{id}','Pedido\PedidoController@producto');
    Route::get('pedidos-imprimir/{id}','Pedido\PedidoController@imprimir');

    Route::resource('comisiones','Comision\ComisionController');

    Route::resource('usuarios','Usuario\UsuarioController');

});

//vendedor
Route::group(['middleware' => ['auth','vendedor']], function() {

    Route::resource('pedidos','Pedido\PedidoController');
    Route::get('pedidos-asociado/{id}','Pedido\PedidoController@asociado');
    Route::get('pedidos-producto/{id}','Pedido\PedidoController@producto');
    Route::get('pedidos-imprimir/{id}','Pedido\PedidoController@imprimir');

});

//digitador
Route::group(['middleware' => ['auth','digitador']], function() {

    Route::resource('paises','Pais\PaisController');

    Route::resource('departamentos','Departamento\DepartamentoController',['except'=>['index','create']]);
    Route::get('pais-departamento/{id}','Departamento\DepartamentoController@inicio');
    Route::get('departamento-registrar/{id}','Departamento\DepartamentoController@registrar');

    Route::resource('municipios','Municipio\MunicipioController',['except'=>['index','create']]);
    Route::get('departamento-municipio/{id}','Municipio\MunicipioController@inicio');
    Route::get('municipio-registrar/{id}','Municipio\MunicipioController@registrar');

    Route::resource('categorias','Categoria\CategoriaController');

    Route::resource('productos','Producto\ProductoController');

    Route::resource('tipo-asociado','TipoAsociado\TipoAsociadoController');

    Route::resource('asociados','Asociado\AsociadoController');
    Route::get('asociados-listar/{listar}','Asociado\AsociadoController@listar');
    Route::get('asociados-departamento/{id}','Asociado\AsociadoController@departamento');
    Route::get('asociados-municipio/{id}','Asociado\AsociadoController@municipio');

});
