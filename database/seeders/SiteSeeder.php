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
            'name' => 'Prefeitura Bom Sucesso',
            'author' => 'Julio Cesar Martins',
            'description' => 'Sistema acesso de wifi para prefeitura de bom sucesso',
            'endereco' => '',
            'telefone' => '',
            'locale' => 'pt-br',
            'root' => '',
            'whatsapp' => '',
            'logo' => 'assets/img/logo.png',
            'favicon' => 'assets/img/favicon.ico',
            'appletouchicon' => 'assets/img/favicon.ico',
            'email' => '',
            'areacliente' => '',
            'googlesiteverification' => '',
            'telegram_bot' => '7755794865:AAFCATnK6I-mdAJCyjO0JjI-0TtsUFwrqnM',
            'telegram_group' => '-4924833416',
            'googlemaps' => '',
            'keywords' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
