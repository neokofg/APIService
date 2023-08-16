<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "price"
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_products', 'product_id', 'user_id');
    }
}
