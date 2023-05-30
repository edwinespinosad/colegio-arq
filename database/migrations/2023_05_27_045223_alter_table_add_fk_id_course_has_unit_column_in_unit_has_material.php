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
        Schema::table('unit_has_material', function (Blueprint $table) {
            $table->unsignedInteger('fk_id_unit')->change()->nullable();

            $table->unsignedInteger('fk_id_course_has_unit');
            $table->foreign('fk_id_course_has_unit')
                ->references('id')
                ->on('course_has_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_has_material', function (Blueprint $table) {
            $table->unsignedInteger('fk_id_unit')->change()->nullable();

            $table->dropColumn('fk_id_course_has_unit');
        });
    }
};
