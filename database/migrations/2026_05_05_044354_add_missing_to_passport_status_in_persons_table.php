<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending_review','approved','change_requested','missing') NOT NULL DEFAULT 'pending_review'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE persons SET passport_status = 'pending_review' WHERE passport_status = 'missing'");
            DB::statement("ALTER TABLE persons MODIFY COLUMN passport_status ENUM('pending_review','approved','change_requested') NOT NULL DEFAULT 'pending_review'");
        }
    }
};
