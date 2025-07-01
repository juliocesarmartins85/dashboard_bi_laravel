<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (json_decode(file_get_contents(public_path() . '/json/bairro.json')) as $key => $bairro) {
            DB::table('enderecos')->insert([
                'sigla' => $bairro->sigla,
                'estado' => $bairro->estado,
                'cidade' => $bairro->cidade,
                'bairro' => $bairro->nome,
                'cep' => $bairro->cep,
                'rua' => $bairro->rua,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
