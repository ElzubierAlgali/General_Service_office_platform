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
class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'code',
        'description',
        'price',
        'estimated_duration_days',
        'workflow_json',
        'active',
        'metadata',
    ];

    protected $casts = [
        'workflow_json' => 'json',
        'metadata' => 'json',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get tasks for this service from workflow_json or tasked relationship.
     * If workflow_json defines task order, use it; otherwise use default_order.
     */
    public function getWorkflowTasks(): array
    {
        if ($this->workflow_json && isset($this->workflow_json['tasks'])) {
            return $this->workflow_json['tasks']; // [{'task_id' => 1, 'order' => 1}, ...]
        }

        return $this->tasks()->orderBy('default_order')->pluck('id')->toArray();
    }
}
