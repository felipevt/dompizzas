<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/category', 'API\CategoryController');
Route::apiResource('/produto', 'API\ProdutoController');
Route::apiResource('/cliente', 'API\ClienteController');
Route::apiResource('/items', 'API\ItemController');
Route::get('/related/{id}', 'API\CategoryController@related');

Route::get('/search', function (){

    $queryString = Input::get('queryString');
    $clientes = \App\Models\ClienteModel::where('nome', 'like','%'.$queryString.'%')->get();
    return response()->json($clientes);

});
