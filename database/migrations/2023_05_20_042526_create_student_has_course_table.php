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
        Schema::create('student_has_course', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_student');
            $table->foreign('fk_id_student')
                ->references('id')
                ->on('student');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_has_course');
    }
};
