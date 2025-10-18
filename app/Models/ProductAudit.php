<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAudit extends Model
{
	protected $fillable = [
		'product_id',
		'user_id',
		'action',
		'changes',
	];

	protected $casts = [
		'changes' => 'array',
	];

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
