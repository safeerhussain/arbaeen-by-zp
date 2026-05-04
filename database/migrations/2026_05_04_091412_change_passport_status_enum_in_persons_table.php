<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Expand enum to include both old and new values so existing rows remain valid
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending','uploaded','approved','pending_review','change_requested') NOT NULL DEFAULT 'pending_review'");
        }

        // Map old values to new (works on both MySQL and SQLite)
        DB::statement("UPDATE persons SET passport_status = 'pending_review' WHERE passport_status IN ('pending', 'uploaded')");

        if (DB::getDriverName() === 'mysql') {
            // Lock to final enum
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending_review','approved','change_requested') NOT NULL DEFAULT 'pending_review'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending','uploaded','approved','pending_review','change_requested') NOT NULL DEFAULT 'pending'");
        }

        DB::statement("UPDATE persons SET passport_status = 'pending' WHERE passport_status IN ('pending_review', 'change_requested')");

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending','uploaded','approved') NOT NULL DEFAULT 'pending'");
        }
    }
};
