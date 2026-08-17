<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sites')->insert([
            'url' => '',
            'name' => '',
            'author' => 'Julio Cesar Martins',
            'description' => '',
            'endereco' => '',
            'telefone' => '',
            'locale' => 'pt-br',
            'root' => '',
            'whatsapp' => '',
            'logo' => '',
            'favicon' => '',
            'appletouchicon' => '',
            'email' => '',
            'areacliente' => '',
            'googlesiteverification' => '',
            'telegram_bot' => '',
            'telegram_group' => '',
            'googlemaps' => '',
            'keywords' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
