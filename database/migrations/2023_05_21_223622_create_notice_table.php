<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('course_has_notices', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_notice');
            $table->foreign('fk_id_notice')
                ->references('id')
                ->on('notice');
        });

        Schema::table('course', function (Blueprint $table) {
            $table->string('link_meet')->nullable();
        });

        Schema::create('unit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link');
            $table->timestamps();
        });

        Schema::create('unit_has_material', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_material');
            $table->foreign('fk_id_material')
                ->references('id')
                ->on('material');

            $table->unsignedInteger('fk_id_unit');
            $table->foreign('fk_id_unit')
                ->references('id')
                ->on('unit');
        });

        Schema::create('course_has_unit', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_unit');
            $table->foreign('fk_id_unit')
                ->references('id')
                ->on('unit');

            $table->unsignedInteger('fk_id_exam')->nullable();
            $table->foreign('fk_id_exam')
                ->references('id')
                ->on('exam');
        });

        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->date('limit_date');
            $table->integer('qualification');
            $table->timestamps();
        });

        Schema::create('course_has_activity', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_activity');
            $table->foreign('fk_id_activity')
                ->references('id')
                ->on('activity');
        });

        Schema::create('student_activity_delivery', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_activity');
            $table->foreign('fk_id_activity')
                ->references('id')
                ->on('activity');
        });

        Schema::create('student_unit_qualification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_unit_qualification');

        Schema::dropIfExists('student_activity_delivery');

        Schema::dropIfExists('course_has_activity');

        Schema::dropIfExists('activity');

        Schema::dropIfExists('course_has_unit');

        Schema::dropIfExists('unit_has_material');

        Schema::dropIfExists('material');

        Schema::dropIfExists('unit');

        Schema::table('course', function (Blueprint $table) {
            $table->dropColumn('link_meet');
        });

        Schema::dropIfExists('course_has_notices');

        Schema::dropIfExists('notice');

    }
};
