<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ps_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // PS3, PS4, PS5
            $table->integer('price_per_hour');
            $table->integer('total_units')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ps_types');
    }
};
