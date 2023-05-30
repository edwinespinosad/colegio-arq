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
        Schema::create('group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('student_has_group', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_student');
            $table->foreign('fk_id_student')
                ->references('id')
                ->on('student');

            $table->unsignedInteger('fk_id_group');
            $table->foreign('fk_id_group')
                ->references('id')
                ->on('group');
        });

        Schema::create('teacher_has_group', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_teacher');
            $table->foreign('fk_id_teacher')
                ->references('id')
                ->on('teacher');

            $table->unsignedInteger('fk_id_group');
            $table->foreign('fk_id_group')
                ->references('id')
                ->on('group');
        });

        Schema::create('course', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('duration');
            $table->string('description');
            $table->string('requirements')->nullable();
            $table->string('image');
            $table->float('price');
            $table->string('type');
            $table->date('date_ini');
            $table->date('date_fin');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('group_has_course', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_group');
            $table->foreign('fk_id_group')
                ->references('id')
                ->on('group');
        });

        Schema::create('exam', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('link');
            $table->date('date_ini');
            $table->date('date_fin');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('course_has_exam', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_exam');
            $table->foreign('fk_id_exam')
                ->references('id')
                ->on('exam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_has_exam');
        Schema::dropIfExists('exam');
        Schema::dropIfExists('group_has_course');
        Schema::dropIfExists('course');
        Schema::dropIfExists('teacher_has_course');
        Schema::dropIfExists('student_has_course');
        Schema::dropIfExists('group');

    }
};
