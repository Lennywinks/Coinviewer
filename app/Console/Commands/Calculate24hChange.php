<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Utils\Statusbar;
use App\Models\Coin;
use App\Models\CoinPrice;
use function PHPSTORM_META\type;

class Calculate24hChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-24h-change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the value shift for each coin and quote in the last 24 hours.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        # Get the two most recent dates
        $dates = CoinPrice::query()
            ->select('date')
            ->distinct()
            ->orderByDesc('date')
            ->take(2)
            ->get();

        $newPrices = CoinPrice::query()
            ->select('coin_id', 'quote', 'date', 'price')
            ->where('date', $dates[0]->date)
            ->orderBy('coin_id')
            ->orderBy('quote')
            ->get();

        $oldPrices = CoinPrice::query()
            ->select('coin_id', 'quote', 'date', 'price')
            ->where('date', $dates[1]->date)
            ->orderBy('coin_id')
            ->orderBy('quote')
            ->get();

        foreach ($newPrices as $newPrice)
        {
            $oldPrice = $oldPrices->filter(function ($price) use ($newPrice) {
                return $price->coin_id == $newPrice->coin_id && $price->quote == $newPrice->quote;
            })->first();

            if ($oldPrice == null) continue;

            if ($newPrice->price > 0 && $oldPrice->price > 0)
            {
                $change_24h = round(($newPrice->price - $oldPrice->price) / $newPrice->price * 100, 5);
                $coinprice = CoinPrice::updateOrCreate(
                    [
                        'coin_id' => $newPrice->coin_id,
                        'date' => $newPrice->date,
                        'quote' => $newPrice->quote,
                    ],
                    [
                        'price_change_24h' => $change_24h,
                    ]);
            }
        }
    }
}
