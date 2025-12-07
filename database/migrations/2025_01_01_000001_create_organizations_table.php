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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subdomain')->unique(); // For routing, multitenancy resolution
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('plan')->default('standard'); // basic, standard, premium
            $table->json('settings')->nullable(); // custom config, features, locale, timezone
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
            $table->string('timezone')->default('UTC');
            $table->string('locale')->default('en');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('subdomain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
