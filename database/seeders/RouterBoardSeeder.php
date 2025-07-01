<?php

namespace Database\Seeders;

use App\Models\RouterBoard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RouterBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('router_boards')->insert([
        //    [
        //        'nome' => 'ROUTER08',
        //        'host' => '192.168.190.208',
        //        'user' => 'onotecnologiaapi',
        //        'pass' => 'Ono@Api135*',
        //        'port' => 80,
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //    [
        //        'nome' => 'ROUTE05',
        //        'host' => '192.168.190.205',
        //        'user' => 'onotecnologiaapi',
        //        'pass' => 'Ono@Api135*',
        //        'port' => 80,
        //        'created_at' => date('Y-m-d H:i:s'),
        //        'updated_at' => date('Y-m-d H:i:s')
        //    ],
        //]);
        $responseToken = json_decode(Http::post(env('API_URL_LOGIN'), [
            'email' => env('API_USER'),
            'password' => env('API_PASS'),
        ])->body());
        $response = json_decode(Http::withHeaders(["Authorization" => "Bearer {$responseToken->token}"])->get(env('API_URL') . 'router_boards')->body(), true);
        foreach ($response as $key => $value) {
            RouterBoard::create($value);
        }
    }
}
