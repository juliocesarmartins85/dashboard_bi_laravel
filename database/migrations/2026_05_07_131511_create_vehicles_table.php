<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->unique(); // Placa
            $table->string('idMoovsec')->nullable(); // ID do veículo no Moovsec
            $table->json('dataMoovsec')->nullable(); // ID do veículo no Moovsec
            $table->string('model')->nullable();
            $table->string('device_serial')->nullable(); // Serial do dispositivo (Adicionar esta linha)
            $table->string('status')->default('active'); // Status (Adicionar esta linha)
            $table->integer('capacity')->nullable();
            $table->boolean('has_accessibility')->default(true);
            $table->decimal('current_lat', 10, 8)->nullable();
            $table->decimal('current_lng', 11, 8)->nullable();
            $table->timestamp('last_update')->nullable();
            // Armazena o nome da linha (ex: "Linha 01") ou route_id
            $table->foreignId('route_id')->nullable()->constrained('routes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
