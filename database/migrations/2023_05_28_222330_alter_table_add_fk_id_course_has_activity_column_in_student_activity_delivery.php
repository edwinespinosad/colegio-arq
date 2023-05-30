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
        Schema::table('student_activity_delivery', function (Blueprint $table) {
            $table->dropForeign(['fk_id_course']);
            $table->dropColumn('fk_id_course');

            $table->dropForeign(['fk_id_activity']);
            $table->dropColumn('fk_id_activity');

            $table->unsignedInteger('fk_id_course_has_activity');
            $table->foreign('fk_id_course_has_activity')
                ->references('id')
                ->on('course_has_activity');

            $table->string('link')->nullable();
            $table->boolean('delivered')->default(0);

            $table->unsignedInteger('fk_id_student')->after('id');
            $table->foreign('fk_id_student')
                ->references('id')
                ->on('student');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_activity_delivery', function (Blueprint $table) {
            $table->unsignedInteger('fk_id_course');
            $table->foreign('fk_id_course')
                ->references('id')
                ->on('course');

            $table->unsignedInteger('fk_id_activity');
            $table->foreign('fk_id_activity')
                ->references('id')
                ->on('activity');

            $table->dropForeign(['fk_id_course_has_activity']);
            $table->dropColumn('fk_id_course_has_activity');

            $table->dropForeign(['fk_id_student']);
            $table->dropColumn('fk_id_student');

            $table->dropColumn('link');
            $table->dropColumn('delivered');

        });
    }
};
