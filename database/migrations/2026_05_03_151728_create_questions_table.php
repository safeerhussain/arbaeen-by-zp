<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Q&A is hardcoded on frontend (Module 8) — this table supports future admin moderation
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('city', 100)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->text('question');
            $table->text('answer')->nullable();
            $table->enum('status', ['pending', 'approved', 'dismissed'])->default('pending');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
