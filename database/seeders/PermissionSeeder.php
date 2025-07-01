<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'product-listar',
            'product-criar',
            'product-editar',
            'product-deletar',
            'funcao-listar',
            'funcao-criar',
            'funcao-editar',
            'funcao-deletar',
            'usuario-listar',
            'usuario-criar',
            'usuario-editar',
            'usuario-deletar',
            'perguntas-listar',
            'perguntas-criar',
            'perguntas-editar',
            'perguntas-deletar',
            'routerboard-listar',
            'routerboard-criar',
            'routerboard-editar',
            'routerboard-deletar',
            'enquete-listar',
            'enquete-criar',
            'enquete-editar',
            'enquete-deletar',
            'blacklist-listar',
            'blacklist-criar',
            'blacklist-editar',
            'blacklist-deletar',
            'profileusers-listar',
            'profileusers-criar',
            'profileusers-editar',
            'profileusers-deletar',
            'sites-listar',
            'sites-criar',
            'sites-editar',
            'sites-deletar',
            'logs-listar',
            'logs-criar',
            'logs-editar',
            'logs-deletar',
            'enderecos-listar',
            'enderecos-criar',
            'enderecos-editar',
            'enderecos-deletar',
            'hotspot-listar',
            'hotspot-criar',
            'hotspot-editar',
            'hotspot-deletar'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
