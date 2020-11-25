<?php

use App\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Produto $produto)
    {
        $produto->create([
            'nome'=>'Mussarela',
            'descricao'=>'as;dlfkajds; ;alsdkjfa;lsdkfj a;sdlfkjasd;flkaj',
            'vlvenda'=>'10.5',
            'vlcusto'=>'8.40',
            'status'=>'1'
        ]);

        $produto->create([
            'nome'=>'Calabresa',
            'descricao'=>'as;dlfkajds; ;alsdkjfa;lsdkfj a;sdlfkjasd;flkaj',
            'vlvenda'=>'4.9',
            'vlcusto'=>'3.7',
            'status'=>'1'
        ]);

    }
}
