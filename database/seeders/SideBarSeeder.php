<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SideBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
                'nome' => 'Usuários',
                'icon' => 'bi bi-people-fill',
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
                'nome' => 'Funções',
                'icon' => 'bi bi-person-lines-fill',
                'url' => '/roles',
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
