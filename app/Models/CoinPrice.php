<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinPrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'volume_24h' => 'float',
        'market_cap' => 'float',
        'ath_price' => 'float',
    ];

    public function coin(): BelongsTo
    {
        return $this
            ->belongsTo(Coin::class, 'coin_id', 'id')
            ->select('id', 'name', 'symbol', 'rank');
    }
}
