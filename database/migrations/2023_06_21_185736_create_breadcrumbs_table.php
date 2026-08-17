<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breadcrumbs', function (Blueprint $table) {
            $table->id();
            $table->string('page')->nullable();
            $table->string('title')->nullable();
            $table->string('bannerimg')->nullable();
            $table->string('bannertitle')->nullable();
            $table->string('bannerbody')->nullable();
            $table->string('breadcrumbs')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breadcrumbs');
    }
};
