<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([TenantScope::class])]
class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'transaction_id',
        'customer_id',
        'invoice_number',
        'status',
        'amount',
        'currency',
        'issued_at',
        'due_at',
        'paid_at',
        'notes',
        'line_items',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'line_items' => 'json',
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Convenience helpers
    public function isPaid(): bool
    {
        return $this->status === 'paid' || !is_null($this->paid_at);
    }

    public function markAsIssued(?\DateTime $issuedAt = null): self
    {
        $this->update([
            'status' => 'issued',
            'issued_at' => $issuedAt ?? now(),
        ]);

        return $this;
    }

    public function markAsPaid(?\DateTime $paidAt = null): self
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => $paidAt ?? now(),
        ]);

        return $this;
    }

    public function calculateTotalFromLineItems(): float
    {
        $items = $this->line_items ?: [];
        $total = 0.0;

        foreach ($items as $item) {
            $qty = isset($item['quantity']) ? (float) $item['quantity'] : 1.0;
            $price = isset($item['unit_price']) ? (float) $item['unit_price'] : 0.0;
            $total += $qty * $price;
        }

        return round($total, 2);
    }
}
