<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'supplier_id',
        'status',
        'created_by',
        'approved_by',
        'received_by',
        'order_date',
        'expected_delivery_date',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    public function canBeApproved(): bool
    {
        return $this->status === 'Draft';
    }

    public function canBeSent(): bool
    {
        return $this->status === 'Approved';
    }

    public function canBeReceived(): bool
    {
        return $this->status === 'Sent';
    }

    public function isFullyReceived(): bool
    {
        return $this->items->every(function ($item) {
            return $item->received_quantity >= $item->quantity;
        });
    }
}
