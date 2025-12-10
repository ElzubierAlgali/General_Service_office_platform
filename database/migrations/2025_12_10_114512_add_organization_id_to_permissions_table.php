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
        // Drop the old unique constraint on name first
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['name']); // Drop the old unique constraint
        });

        // Add organization_id to permissions table for tenant-scoped permissions
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unique(['organization_id', 'name']); // Unique permission per tenant (or global if null)
            $table->index('organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropUnique(['organization_id', 'name']);
            $table->dropIndex(['organization_id']);
            $table->dropColumn('organization_id');
            // Restore the old unique constraint
            $table->unique('name');
        });
    }
};
