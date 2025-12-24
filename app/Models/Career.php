<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
	/** @use HasFactory<\Database\Factories\CareerFactory> */
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'requirements',
		'status',
		'closing_date',
		'recruitment_link',
	];
}
