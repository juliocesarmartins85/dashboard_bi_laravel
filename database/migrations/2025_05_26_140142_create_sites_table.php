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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('name')->nullable();
            $table->string('author')->nullable();
            $table->string('description')->nullable();
            $table->string('endereco')->nullable();
            $table->string('telefone')->nullable();
            $table->string('locale')->nullable();
            $table->string('root')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('appletouchicon')->nullable();
            $table->string('email')->nullable();
            $table->string('areacliente')->nullable();
            $table->string('googlesiteverification')->nullable();
            $table->text('telegram_bot')->nullable();
            $table->text('telegram_group')->nullable();
            $table->text('googlemaps')->nullable();
            $table->text('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
