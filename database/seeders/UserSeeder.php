<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arryusr = [
            [
                'name' => 'Julio Cesar',
                'funcao' => 'Developer',
                'funcaosis' => 'admin',
                'desc' => 'desenvolvedor',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'admin@admin.com',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Api Aplicativo',
                'funcao' => 'Developer',
                'funcaosis' => 'admin',
                'desc' => 'desenvolvedor',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'app@admin.com',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Daniel Tinoco',
                'funcao' => 'Suporte',
                'funcaosis' => 'admin',
                'desc' => 'Suporte',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'suporte02@grupofonelight.com.br',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => "Luan D'Martin",
                'funcao' => 'Suporte',
                'funcaosis' => 'admin',
                'desc' => 'Suporte',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'suporte01@rotasoftware.com.br',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => "REBECCA BRASILEIRO",
                'funcao' => 'Suporte',
                'funcaosis' => 'admin',
                'desc' => 'Suporte',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'atendimento07@grupofonelight.com.br',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => "FELIPE EMANUEL DA SILVA",
                'funcao' => 'Suporte',
                'funcaosis' => 'admin',
                'desc' => 'Suporte',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'atendimento06@onotecnologia.com.br',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => "YURI TAVARES",
                'funcao' => 'marketing',
                'funcaosis' => 'admin',
                'desc' => 'marketing',
                'endereco' => '',
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#',
                'foto' => '',
                'email' => 'marketing01@onotecnologia.com.br',
                'status' => true,
                'organizacao' => 'onotecnologia',
                'telefone' => '(00)99999-9999',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($arryusr as $key => $value) {
            $user = User::create($value);

            if ($key == 0) {
                # code...
                $role = Role::create(['name' => 'Admin']);

                $permissions = Permission::pluck('id', 'id')->all();

                $role->syncPermissions($permissions);
            }

            $user->assignRole([$role->id]);
        }
    }
}
