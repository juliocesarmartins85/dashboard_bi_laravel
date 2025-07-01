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
        Schema::create('device_histories', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('host_name')->nullable();
            $table->string('ip_adress')->nullable();
            $table->string('server')->nullable();
            $table->string('hotspot')->nullable();
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
        Schema::dropIfExists('device_histories');
    }
};
