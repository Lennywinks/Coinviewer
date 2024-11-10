<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function coin(): BelongsTo
    {
        return $this
            ->belongsTo(Coin::class, 'coin_id', 'id')
            ->select('id', 'name', 'symbol', 'rank')
            ->with('prices');
    }
}
