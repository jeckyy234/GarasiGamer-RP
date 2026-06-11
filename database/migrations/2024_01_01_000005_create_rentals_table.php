<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ps_type_id')->constrained();
            $table->string('customer_name');
            $table->decimal('duration_hours', 5, 1);
            $table->integer('total_price');
            $table->dateTime('rental_date');
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
