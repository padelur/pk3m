<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOutItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_out_id',
        'product_id',
        'quantity',
        'price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function stockOut(): BelongsTo
    {
        return $this->belongsTo(StockOut::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}


