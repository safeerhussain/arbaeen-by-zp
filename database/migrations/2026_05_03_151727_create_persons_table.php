<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('person_id', 14)->unique(); // AR01-042-01
            $table->unsignedTinyInteger('position'); // 1 = lead, 2+ = family
            $table->string('full_name', 100);
            $table->string('fathers_name', 100)->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->enum('passenger_type', ['adult', 'child_with_bed', 'child_without_bed', 'infant']);
            $table->string('relationship', 50)->nullable(); // spouse, son, daughter, etc.
            $table->date('passport_expiry')->nullable();
            $table->enum('passport_status', ['pending_review', 'approved', 'change_requested'])->default('pending_review');
            // Contact fields — lead only (position = 1)
            $table->string('mobile', 20)->nullable();
            $table->string('alternate_mobile', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('city', 100)->nullable();
            // Health
            $table->boolean('wheelchair_required')->default(false);
            $table->text('medical_notes')->nullable();
            // Pricing snapshot
            $table->unsignedSmallInteger('price_usd')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
