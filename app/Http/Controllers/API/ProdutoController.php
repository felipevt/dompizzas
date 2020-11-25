<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProdutoResource;
use App\Produto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function GuzzleHttp\json_encode;


class ProdutoController extends Controller
{
    protected $repository;

    public function __construct(Produto $repository)
    {
        $this->repository = $repository;
        //$this->middleware('auth:api');
    }


    public function index()
    {

        return ProdutoResource::collection(Produto::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'nome' => ['required', 'string', 'max:255', 'unique:produtos'],
    ]);
        return  $this->repository->create([
            'nome' => $request['nome'],
            'descricao' => $request['descricao'],
            'vlvenda' => $request['vlvenda']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->repository->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nome' => ['required', 'string', 'max:191'],
        ]);
        $this->repository->findOrFail($id)->update($request->all());
        // return 'Updating data';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->findOrFail($id)->delete();
    }

    public function related($id)
    {
        $posts = Produto::with('item')->find($id);

        // return $posts;
        return response()->json($posts);
    }


}
