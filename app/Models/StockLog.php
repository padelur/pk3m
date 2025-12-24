<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'change_type',
        'quantity_change',
        'stock_before',
        'stock_after',
        'description',
        'reference_number',
        'created_by',
    ];

    protected $casts = [
        'quantity_change' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('change_type', $type);
    }

    public function scopeRecent($query, int $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
