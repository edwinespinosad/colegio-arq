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
        Schema::create('teacher_has_courses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_teacher');
            $table->foreign('fk_id_teacher')
                ->references('id')
                ->on('teacher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_has_courses');
    }
};
