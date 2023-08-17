<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "price",
        "is_rentable"
    ];

    protected $appends = ['isBuyed','oneHourPrice','isRented'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function rentedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_products_rent')
            ->withPivot('rent_end_date','rent_hours');
    }

    public function rents(): HasMany
    {
        return $this->hasMany(UserProductRent::class, 'product_id', 'id');
    }

    public function getIsBuyedAttribute()
    {
        return $this->user()->exists();
    }

    public function getIsRentedAttribute()
    {
        return $this->rents()->exists();
    }

    public function getOneHourPriceAttribute()
    {
        return intval($this->price / 24);
    }
}
