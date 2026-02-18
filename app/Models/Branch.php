<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location',
        'is_active'
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
