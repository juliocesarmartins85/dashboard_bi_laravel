<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usr = [
            [
                'name' => 'Developer',
                'email' => 'admin@admin.com',
                'funcao' => 'developer',
                'funcaosis' => 'developer',
                'password' => bcrypt('tagima19856')
            ],
            [
                'name' => 'BRUNO PARAVIZO BARÃO',
                'email' => 'suporte@fonelight.com.br',
                'funcao' => 'developer',
                'funcaosis' => 'developer',
                'password' => bcrypt('Fonelight@135')
            ],
        ];

        $role = Role::create(['name' => 'developer']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        foreach ($usr as $k => $v) {
            $user = User::create($v);
            $user->assignRole([$role->id]);
        }
    }
}
