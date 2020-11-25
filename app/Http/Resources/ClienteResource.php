<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
        "id" => $this->id,
        "nome" => $this->nome,
        "documento" => $this->documento,
        "email" => $this->email,
        "telefone" => $this->telefone,
        "endereco" => $this->endereco,
        "cep" => $this->cep,
        "status" => $this->status
        ];
    }
}
