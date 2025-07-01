<?php

namespace Database\Seeders;

use App\Models\ProfileUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProfileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responseToken = json_decode(Http::post(env('API_URL_LOGIN'), [
            'email' => env('API_USER'),
            'password' => env('API_PASS'),
        ])->body());
        $response = json_decode(Http::withHeaders(["Authorization" => "Bearer {$responseToken->token}"])->get(env('API_URL').'profile_users')->body(),true);
        foreach ($response as $key => $value) {
            ProfileUser::create($value);
        }
    }
}
