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
        Schema::create('webs', function (Blueprint $table) {
            $table->id();
            $table->string("url")->nullable();
            $table->string("emp")->nullable();
            $table->string("name")->nullable();
            $table->string("desc")->nullable();
            $table->string("endereco")->nullable();
            $table->string("telefonefixo")->nullable();
            $table->string("telefone0800")->nullable();
            $table->string("telefone")->nullable();
            $table->string("locale")->nullable();
            $table->string("root")->nullable();
            $table->string("whatsappnum")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("favicon")->nullable();
            $table->string("logo")->nullable();
            $table->string("email")->nullable();
            $table->string("quem_somos")->nullable();
            $table->string("form_contact")->nullable();
            $table->string("areacliente")->nullable();
            $table->string("asset_web")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webs');
    }
};
