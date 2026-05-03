<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('persons')->cascadeOnDelete();
            $table->enum('type', ['passport', 'photo']);
            $table->string('original_filename', 255);
            $table->string('stored_path', 500);
            $table->string('mime_type', 100);
            $table->unsignedInteger('file_size'); // bytes
            $table->string('drive_url', 500)->nullable(); // Module 12
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
