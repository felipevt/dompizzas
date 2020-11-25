<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ClienteResource;
use App\Models\ClienteModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    protected $repository;

    public function __construct(ClienteModel $repository)
    {
        $this->repository = $repository;
        //$this->middleware('auth:api');
    }

    public function index(){
        return ClienteResource::collection(ClienteModel::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => ['required', 'string', 'max:255', 'unique:clientes'],
        ]);
        return $this->repository->create([
            'nome' => $request['nome'],
            'email' => $request['email'],
            'documento' => $request['documento'],
            'telefone' => $request['telefone'],
            'endereco' => $request['endereco'],
            'cep' => $request['cep'],
            'status' => $request['status']
        ]);

    }

    public function show($id)
    {
        return response()->json($this->repository->findorFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nome' => ['required', 'string', 'max:255'],
        ]);
        $this->repository->findOrFail($id)->update($request->all());
        // return 'Updating data';
    }

    public function destroy($id)
    {
        $this->repository->findOrFail($id)->delete();
    }

}
