<?php

namespace Database\Seeders;

use App\Models\Hotspot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HotspotSeeder extends Seeder
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
        $response = json_decode(Http::withHeaders(["Authorization" => "Bearer {$responseToken->token}"])->get(env('API_URL') . 'hotspots')->body(), true);
        foreach ($response as $key => $value) {
            Hotspot::create($value);
        }
        //try {
        //    $h = new Hotspot();
        //    $h->nome = 'painel1';
        //    $h->host = '192.168.190.208';
        //    $h->user = 'admin';
        //    $h->pass = 'Fonelight@135';
        //    $h->port = '8088';
        //    $h->token = '';
        //    $h->save();
        //} catch (\Exception $e) {
        //    Log::info($e->getMessage());
        //}
        //try {
        //    $h = new Hotspot();
        //    $h->nome = 'painel1';
        //    $h->host = '192.168.190.208';
        //    $h->user = 'admin';
        //    $h->pass = 'Fonelight@135';
        //    $h->port = '8089';
        //    $h->token = '';
        //    $h->save();
        //} catch (\Exception $e) {
        //    Log::info($e->getMessage());
        //}
        /*         try {
            $h = new Hotspot();
            $h->nome = 'painel1';
            $h->host = '177.91.33.80';
            $h->user = 'admin';
            $h->pass = 'Fonelight135*';
            $h->port = '5555';
            $h->token = '';
            $h->save();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        try {
            $h = new Hotspot();
            $h->nome = 'painel1';
            $h->host = '177.91.33.80';
            $h->user = 'admin';
            $h->pass = 'Fonelight135*';
            $h->port = '5556';
            $h->token = '';
            $h->save();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        } */
    }
}
