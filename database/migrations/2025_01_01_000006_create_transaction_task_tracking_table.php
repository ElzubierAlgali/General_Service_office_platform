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
        Schema::create('transaction_task_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('task_id');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'blocked', 'skipped'])->default('pending');
            $table->unsignedBigInteger('assigned_to')->nullable(); // current owner
            $table->unsignedBigInteger('created_by')->nullable(); // who created this tracking row
            $table->unsignedBigInteger('updated_by')->nullable(); // last modified by
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('attempts')->default(0); // retry count
            $table->json('payload')->nullable(); // step-specific output or state
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('restrict');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->unique(['transaction_id', 'task_id']); // one tracking row per transaction-task pair
            $table->index('organization_id');
            $table->index('status');
            $table->index(['organization_id', 'status']);
            $table->index(['transaction_id', 'status']);
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_task_tracking');
    }
};
