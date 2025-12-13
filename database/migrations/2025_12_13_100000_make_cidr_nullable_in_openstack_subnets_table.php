<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use DB facade for column modification to handle index properly
        DB::statement('ALTER TABLE `openstack_subnets` MODIFY `cidr` VARCHAR(50) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This will fail if there are null values
        DB::statement('ALTER TABLE `openstack_subnets` MODIFY `cidr` VARCHAR(50) NOT NULL');
    }
};

