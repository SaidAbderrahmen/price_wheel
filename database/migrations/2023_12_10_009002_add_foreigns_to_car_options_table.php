<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_options', function (Blueprint $table) {
            $table
                ->foreign('car_version_id')
                ->references('id')
                ->on('car_versions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_options', function (Blueprint $table) {
            $table->dropForeign(['car_version_id']);
        });
    }
};
