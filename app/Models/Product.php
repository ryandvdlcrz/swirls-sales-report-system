<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name'];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function flavors(): BelongsToMany
    {
        return $this->belongsToMany(Flavor::class, 'product_flavors');
    }
}
