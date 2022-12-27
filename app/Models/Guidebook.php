<?php

namespace App\Models;

use App\Models\Scopes\LoggedUserScope;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidebook extends Model
{
  use UUID;
  use HasFactory;

  protected $fillable = [
    'user_id', 'title', 'description', 'is_published'
  ];

    public $timestamps = true;

    protected static function booted()
  {
    static::addGlobalScope(new LoggedUserScope);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function places()
  {
    return $this->hasMany(Place::class);
  }

    public function favorizers()
    {
    return $this->hasMany(User::class);
    }
}
