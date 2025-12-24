<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	/** @use HasFactory<\Database\Factories\SettingFactory> */
	use HasFactory;

	protected $fillable = [
		'company_name',
		'address',
		'email',
		'phone',
		'whatsapp_link',
		'instagram_url',
		'facebook_url',
		'linkedin_url',
		'catalog_pdf_path',
		'map_embed_url',
	];
}
