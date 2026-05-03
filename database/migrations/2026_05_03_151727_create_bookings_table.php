<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 10)->unique(); // AR01-042
            $table->enum('group', ['AR01', 'AR02']);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->enum('departure_city', ['karachi', 'lahore', 'islamabad']);
            $table->enum('package_type', ['full', 'ground_only']);
            $table->boolean('campaign_discount')->default(false);
            $table->string('heard_about_us')->nullable();
            $table->boolean('previous_arbaeen')->default(false);
            $table->boolean('public_feed_consent')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
