<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->unsignedTinyInteger('unit_number')->nullable()->after('ps_type_id');
        });
    }

    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('unit_number');
        });
    }
};
