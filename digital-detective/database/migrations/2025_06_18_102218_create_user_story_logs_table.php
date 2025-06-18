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
        Schema::create('user_story_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('story_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('question_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('option_id')->nullable()->constrained()->onDelete('set null');

            $table->text('user_input')->nullable();

            $table->boolean('is_correct_answer')->nullable();

            $table->string('event_type')->nullable(); 
            $table->text('event_description')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_story_logs');
    }
};