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
        Schema::create('semester_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rank');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('table_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('table_id')->references('id')->on('tables');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_users');
    }
};
