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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('accountant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->integer('age')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
        Schema::dropIfExists('teacher');
        Schema::dropIfExists('accountant');
        Schema::dropIfExists('users');
    }
};
