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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            // Identificação da Linha (Ex: Linha 01)
            $table->string('linha');

            // Descrição do Itinerário (Ex: JOÃO DE DEUS - SANTA MÔNICA)
            $table->string('itinerario');

            $table->string('seq'); // Nome do ponto/parada (Ex: Ponto 01)

            // Localização exata ou endereço (Ex: Ponto 01 - Av. Daniel de Carvalho)
            $table->text('localizacao');

            // Status da sinalização/ponto (Ex: Executado, Falta executar, Remanejar)
            $table->integer('status')->default(0);

            // Mantive estes como opcionais caso você decida usar GPS futuramente
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
            $table->foreignId('route_id')->nullable()->constrained('routes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
