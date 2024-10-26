<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coin extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function prices(): HasMany
    {
        return $this->hasMany(CoinPrice::class);
    }

    public function currentPrice(): HasOne
    {
        return $this
            ->hasOne(CoinPrice::class)
            ->orderByDesc('date')
            ->latest()
            ->select(['coin_id', 'date', 'quote', 'price']);
    }
}
