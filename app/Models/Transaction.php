<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([TenantScope::class])]
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'customer_id',
        'service_id',
        'reference_number',
        'status',
        'priority',
        'submitted_by',
        'assigned_to',
        'submitted_at',
        'due_date',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
        'submitted_at' => 'datetime',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function taskTrackings(): HasMany
    {
        return $this->hasMany(TransactionTaskTracking::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Materialize workflow: create transaction_task_tracking rows from service tasks.
     * Called when transaction is submitted.
     */
    public function materializeWorkflow(): void
    {
        $service = $this->service()->with('tasks')->first();
        $taskIds = $service->getWorkflowTasks();

        foreach ($taskIds as $index => $taskId) {
            TransactionTaskTracking::create([
                'organization_id' => $this->organization_id,
                'transaction_id' => $this->id,
                'task_id' => $taskId,
                'status' => $index === 0 ? 'pending' : 'pending', // first can be in_progress if auto-start
            ]);
        }
    }
}
