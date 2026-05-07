<?php

namespace Database\Seeders;

use App\Helpers\WebHelper;
use App\Models\Driver;
use App\Models\Neighborhood;
use App\Models\Vehicle;
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
        $this->call(SideBarSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(UserAdminSeeder::class);
        Driver::factory(10)->create();

        foreach (WebHelper::apiGetMoovsec('/vehicle/all/true') as $v) {
            Vehicle::create([
                'plate'         => $v['plate'] ?? 'SEM-PLACA',
                'idMoovsec'     => $v['_id'] ?? '',
                'dataMoovsec'   => $v,
                'device_serial' => $v['deviceList'][0]['deviceSerial'] ?? null,
                'model'         => 'Onibus', // Valor fixo ou vindo de outra chave do JSON
                'capacity'      => 99, // Valor fixo ou vindo de outra chave do JSON
                'status'        => 'active',
            ]);

            $this->command->info("Veículo cadastrado: " . ($v['plate'] ?? 'Desconhecido'));
        }

        $this->call(StopSeeder::class);

        // 1. Cadastro de todos os Bairros citados no relatório
        $bairros = [
            'Centro',
            'Vila Nova',
            'Federal',
            'São Lourenço Velho',
            'Ramon',
            'Vila Pascoal',
            'Palmela',
            'Santa Mônica',
            'Sonda',
            'Jardim Juliana',
            'N. Sra. Lourdes',
            'João de Deus',
            'COHAB',
            'Carioca',
            'Alto Federal'
        ];

        $nIds = [];
        foreach ($bairros as $nome) {
            $n = Neighborhood::create(['name' => $nome]);
            $nIds[$nome] = $n->id;
        }
    }
}
