<?php

use App\Models\CriteriaQuestionUser;
use App\Models\Curator;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignIdFor(Curator::class)->references('id')->on('curators');
            $table->foreignId('question_id')->references('id')->on('table_question_users')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('semester_users')->cascadeOnDelete();
            $table->boolean('is_viewed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
