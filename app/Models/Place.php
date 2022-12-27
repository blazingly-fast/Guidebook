<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
	use UUID;
	use HasFactory;


	protected $fillable = [
		'guidebook_id', 'title', 'description'
	];

    public $timestamps = true;

	public function guidebook()
	{
		return $this->belongsTo(Guidebook::class);
	}
}
