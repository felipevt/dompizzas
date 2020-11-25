<?php

use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Models\ClienteModel $cliente)
    {
        $cliente->create([
            'nome'=>'Samambaia',
            'email'=>'samambaia@gmail.com',
            'documento'=>'09876543212',
            'telefone'=>'61999457373',
            'endereco'=>'Teste de endereco',
            'cep'=>'719993483',
            'status'=>'1',
        ]);

        $cliente->create([
            'nome'=>'Águas Claras',
            'email'=>'aguaclarasdompizza@gmail.com',
            'documento'=>'12345678906',
            'telefone'=>'6123456789',
            'endereco'=>'Teste de endereco de águas claras',
            'cep'=>'719993483',
            'status'=>'1',
        ]);



    }
}
