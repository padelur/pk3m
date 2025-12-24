<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'notes',
        'request_date',
        'created_by',
        'status',
        'approved_by',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'request_date' => 'date',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DRAFT = 'Draft';
    const STATUS_APPROVED = 'Approved';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_REJECTED = 'Rejected';

    public function items(): HasMany
    {
        return $this->hasMany(StockOutItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getTotalAmountAttribute(): float
    {
        return (float) $this->items->sum(function ($item) {
            return ($item->price ?? 0) * $item->quantity;
        });
    }

    public function canBeApproved(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function canBeCompleted(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}


