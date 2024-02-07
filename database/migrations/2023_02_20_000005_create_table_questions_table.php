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
        Schema::create('table_questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->text('options');
            $table->unsignedBigInteger('curator_id');
            $table->unsignedBigInteger('table_id');
            $table->foreign('curator_id')->references('id')->on('curators');
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
            $table->enum('type', [1, 2, 3, 4]);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_questions');
    }
};
