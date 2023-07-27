<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('rank');
            $table->unsignedBigInteger('table_id');
            $table->foreign('table_id')->references('id')->on('tables');
            $table->enum('is_admin', [0, 1])->default(0);
            $table->enum('is_curator', [0, 1])->default(0);
            $table->unsignedBigInteger('curator_id')->nullable();
            $table->foreign('curator_id')->references('id')->on('curators');
            $table->enum('is_hide', [0, 1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
