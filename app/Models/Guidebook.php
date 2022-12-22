<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidebook extends Model
{
	use UUID;
	use HasFactory;

	protected $fillable = [
		'user_id', 'title', 'description'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function places()
	{
		return $this->hasMany(Place::class);
	}
}
