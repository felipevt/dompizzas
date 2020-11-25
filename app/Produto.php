<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;


class Produto extends Model
{
    // use HasApiTokens;

    protected $fillable = ['nome','descricao','vlvenda'];
    protected $table = 'produtos';


   // public function item()
    //{
   //     return $this->hasMany(Item::class);
   // }
}
