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
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->uuid('project_id')->index();
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
            
            $table->foreignId('user_id')->index();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Role in project
            $table->enum('role', [
                'admin',
                'member',
                'viewer'
            ])->default('member')->index();
            
            // OpenStack role mapping (if synced)
            $table->string('openstack_role_id', 255)->nullable()->index();
            
            // Timestamps
            $table->timestamps();
            
            // Unique constraint: one user can have one role per project
            $table->unique(['project_id', 'user_id']);
            
            // Indexes
            $table->index(['user_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
