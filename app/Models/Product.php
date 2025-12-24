<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
	/** @use HasFactory<\Database\Factories\ProductFactory> */
	use HasFactory;

	protected $fillable = [
		'name',
		'slug',
		'brand_id',
		'category_id',
		'description',
		'size',
		'price',
		'stock',
		'image_path',
		'pdf_path',
		'e_catalog_url',
		'is_active',
	];

	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function audits(): HasMany
	{
		return $this->hasMany(ProductAudit::class);
	}

	public function stockLogs(): HasMany
	{
		return $this->hasMany(StockLog::class);
	}

	public function purchaseOrderItems(): HasMany
	{
		return $this->hasMany(PurchaseOrderItem::class);
	}

	public function scopePublicVisible($query)
	{
		return $query->where('is_active', true)->where('stock', '>', 0);
	}

	/**
	 * Update stock and create log
	 */
	public function updateStock(int $quantityChange, string $changeType, string $description = null, string $referenceNumber = null, ?int $userId = null): void
	{
		$stockBefore = $this->stock;
		$this->stock += $quantityChange;
		$this->save();

		StockLog::create([
			'product_id' => $this->id,
			'change_type' => $changeType,
			'quantity_change' => $quantityChange,
			'stock_before' => $stockBefore,
			'stock_after' => $this->stock,
			'description' => $description,
			'reference_number' => $referenceNumber,
			'created_by' => $userId ?? auth()->id(),
		]);
	}
}
