<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('router_boards', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('host')->nullable();
            $table->string('user')->nullable();
            $table->string('pass')->nullable();
            $table->integer('port')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('router_boards');
    }
};
