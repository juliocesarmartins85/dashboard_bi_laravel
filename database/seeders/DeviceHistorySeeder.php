<?php

namespace Database\Seeders;

use App\Models\DeviceHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceHistorySeeder extends Seeder
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
        $response = json_decode(Http::withHeaders(["Authorization" => "Bearer {$responseToken->token}"])->get(env('API_URL').'device_histories')->body(), true);
        foreach ($response as $key => $value) {
            DeviceHistory::create($value);
        }
    }
}
