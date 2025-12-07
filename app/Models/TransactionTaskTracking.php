<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([TenantScope::class])]
class TransactionTaskTracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_task_tracking';

    protected $fillable = [
        'organization_id',
        'transaction_id',
        'task_id',
        'status',
        'assigned_to',
        'created_by',
        'updated_by',
        'started_at',
        'completed_at',
        'attempts',
        'payload',
        'notes',
    ];

    protected $casts = [
        'payload' => 'json',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Mark this tracking as in progress, capturing start time.
     */
    public function start(): self
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark this tracking as completed.
     */
    public function complete(array $payload = []): self
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'payload' => $payload,
        ]);

        return $this;
    }

    /**
     * Mark as blocked.
     */
    public function block(string $reason = ''): self
    {
        $this->update([
            'status' => 'blocked',
            'notes' => $reason,
        ]);

        return $this;
    }
}
