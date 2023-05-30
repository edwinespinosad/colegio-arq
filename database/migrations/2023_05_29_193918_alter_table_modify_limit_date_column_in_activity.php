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
        Schema::table('activity', function (Blueprint $table) {
            $table->datetime('limit_date')->change();
        });

        Schema::table('student_activity_delivery', function (Blueprint $table) {
            $table->decimal('qualification', 8, 2)->after('link')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_activity_delivery', function (Blueprint $table) {
            $table->dropColumn('qualification');
        });

        Schema::table('activity', function (Blueprint $table) {
            $table->date('limit_date')->change();
        });
    }
};
