<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SideBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('side_bars')->insert([
            [
                'nome' => 'Dashboard',
                'icon' => 'bi bi-grid',
                'url' => '/home',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Enquete',
                'icon' => 'bi bi-person-lines-fill',
                'url' => '/enquetes',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Perguntas',
                'icon' => 'bi bi-question-square-fill',
                'url' => '/perguntas',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'RouterBoard',
                'icon' => 'bi bi-router-fill',
                'url' => '/routerboard',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Administradores',
                'icon' => 'bi bi-person-badge',
                'url' => '/user',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Usuários',
                'icon' => 'bi bi-person-bounding-box',
                'url' => '/profileusers',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Funções',
                'icon' => 'bi bi-building-gear',
                'url' => '/roles',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Dados Sistemas',
                'icon' => 'bi bi-file',
                'url' => '/sites',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Bairros',
                'icon' => 'bi bi-map',
                'url' => '/enderecos',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Hotspots',
                'icon' => 'bi bi-router',
                'url' => '/hotspot',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Logs',
                'icon' => 'bi bi-file-earmark-code-fill',
                'url' => '/logs',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Blacklist',
                'icon' => 'bi bi-x-octagon',
                'url' => '/blacklists',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
