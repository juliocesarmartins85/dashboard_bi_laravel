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
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();
            $table->string('question')->nullable();
            $table->string('type')->nullable();
            $table->string('options')->nullable();
            $table->boolean('status')->nullable();
            $table->string('interval')->nullable();
            $table->string('dtinicio')->nullable();
            $table->string('dtfinal')->nullable();
            $table->string('nivel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};
