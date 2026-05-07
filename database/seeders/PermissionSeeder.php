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
            'driver-listar',
            'driver-criar',
            'driver-editar',
            'driver-deletar',
            'route-listar',
            'route-criar',
            'route-editar',
            'route-deletar',
            'vehicle-listar',
            'vehicle-criar',
            'vehicle-editar',
            'vehicle-deletar',
            'stop-listar',
            'stop-criar',
            'stop-editar',
            'stop-deletar',
            'street-listar',
            'street-criar',
            'street-editar',
            'street-deletar',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
