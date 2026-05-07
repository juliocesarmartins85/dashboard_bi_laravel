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
                'nome' => 'Administradores',
                'icon' => 'bi bi-person-badge',
                'url' => '/users',
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
                'nome' => 'Motoristas',
                'icon' => 'bi bi-person-badge-fill',
                'url' => '/drivers',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Veículos',
                'icon' => 'bi bi-bus-front-fill',
                'url' => '/vehicles',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Linhas de Ônibus',
                'icon' => 'bi bi-signpost-split-fill',
                'url' => '/routes',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Pontos de Parada',
                'icon' => 'bi bi-geo-alt-fill',
                'url' => '/stops',
                'nvl' => 1,
                'ativo' => true,
                'ancent' => '',
                'descent' => '',
                'drop' => false,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Ruas',
                'icon' => 'bi bi-map-fill',
                'url' => '/streets',
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
        ]);
    }
}
