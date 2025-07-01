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
        Schema::create('router_board_users', function (Blueprint $table) {
            $table->id();
            $table->string('id_rb')->nullable();
            $table->string('server')->nullable();
            $table->string('name')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('profile')->nullable();
            $table->string('limit_uptime')->nullable();
            $table->string('uptime')->nullable();
            $table->string('bytes_in')->nullable();
            $table->string('bytes_out')->nullable();
            $table->string('packets_in')->nullable();
            $table->string('packets_out')->nullable();
            $table->string('dynamic')->nullable();
            $table->string('disabled')->nullable();
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
        Schema::dropIfExists('router_board_users');
    }
};
