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
        Schema::create('pergunta_respostas', function (Blueprint $table) {
            $table->id();
            $table->integer('perguntas_id')->unsigned();
            $table->integer('respostas_id')->unsigned();
            $table->foreign('perguntas_id')->references('id')->on('perguntas')
                ->onDelete('cascade');
            $table->foreign('respostas_id')->references('id')->on('respostas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pergunta_respostas');
    }
};
