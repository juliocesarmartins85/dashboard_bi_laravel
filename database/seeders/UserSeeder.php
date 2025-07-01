<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;
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
        //$user = User::create([
        //    'name' => 'Julio Cesar',
        //    'funcao' => 'Developer',
        //    'funcaosis' => 'admin',
        //    'desc' => 'desenvolvedor',
        //    'endereco' => '',
        //    'facebook' => '#',
        //    'twitter' => '#',
        //    'instagram' => '#',
        //    'linkedin' => '#',
        //    'foto' => '',
        //    'email' => 'admin@admin.com',
        //    'status' => true,
        //    'organizacao' => 'onotecnologia',
        //    'telefone' => '(00)99999-9999',
        //    'password' => bcrypt('tagima19856'),
        //    'created_at' => date('Y-m-d H:i:s'),
        //    'updated_at' => date('Y-m-d H:i:s')
        //]);

        //$role = Role::create(['name' => 'Admin']);
        //$permissions = Permission::pluck('id', 'id')->all();
        //$role->syncPermissions($permissions);
        //$user->assignRole([$role->id]);

        //$responseToken = json_decode(Http::post(env('API_URL_LOGIN'), [
        //    'email' => env('API_USER'),
        //    'password' => env('API_PASS'),
        //])->body());
        //$response = json_decode(Http::withHeaders(["Authorization" => "Bearer {$responseToken->token}"])->get(env('API_URL').'dataSeed/users')->body(), true);
        //foreach ($response as $key => $value) {
        //    if ($value['email'] != 'admin@admin.com') {
        //        User::create($value);
        //    }
        //}
    }
}
