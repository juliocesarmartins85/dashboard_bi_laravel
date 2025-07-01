<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(ProfileUserSeeder::class);
        $this->call(SideBarSeeder::class);
        $this->call(BreadcrumbsSeeder::class);
        $this->call(EnderecoSeeder::class);
        $this->call(EnqueteSeeder::class);
        $this->call(PerguntasSeeder::class);
        $this->call(PerguntaRespostaSeeder::class);
        $this->call(RouterBoardSeeder::class);
        $this->call(HotspotSeeder::class);
        $this->call(RespostasSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(DeviceHistorySeeder::class);
        $this->call(UserAdminSeeder::class);
    }
}
