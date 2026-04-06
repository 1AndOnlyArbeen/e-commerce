<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` CHANGE `staus` `status` VARCHAR(50) DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` CHANGE `status` `staus` VARCHAR(50) DEFAULT 'pending'");
    }
};
