<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    protected $fillable = ['nome','email','documento','telefone','endereco','cep', 'status'];

    protected $table = 'clientes';



}
