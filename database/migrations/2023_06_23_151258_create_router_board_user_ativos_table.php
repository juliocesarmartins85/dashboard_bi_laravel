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
        Schema::create('router_board_user_ativos', function (Blueprint $table) {
            $table->id();
            $table->string('id_rb')->nullable();
            $table->string('server')->nullable();
            $table->string('user')->nullable();
            $table->string('address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('login_by')->nullable();
            $table->string('uptime')->nullable();
            $table->string('session_time_left')->nullable();
            $table->string('idle_time')->nullable();
            $table->string('keepalive_timeout')->nullable();
            $table->string('bytes_in')->nullable();
            $table->string('bytes_out')->nullable();
            $table->string('packets_in')->nullable();
            $table->string('packets_out')->nullable();
            $table->string('radius')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('router_board_user_ativos');
    }
};
