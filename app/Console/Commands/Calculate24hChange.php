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

        $i = 0;
        $wrong = 0;
        foreach ($newPrices as $index => $newPrice)
        {

            $oldPrice = $oldPrices->filter(function ($price) use ($newPrice) {
                return $price->coin_id == $newPrice->coin_id && $price->quote == $newPrice->quote;
            })->first();

            if ($oldPrice == null) continue;

            print('$newPrice->coin_id: ' . $newPrice->coin_id . PHP_EOL);
            print('$newPrice->quote: ' . $newPrice->quote . PHP_EOL);
            print('$newPrice->price: ' . $newPrice->price. PHP_EOL);

            print('$oldPrice->coin_id: ' . $oldPrice->coin_id . PHP_EOL);
            print('$oldPrice->quote: ' . $oldPrice->quote . PHP_EOL);
            print('$oldPrice->price: ' . $oldPrice->price. PHP_EOL);


            if ($newPrice->coin_id != $oldPrice->coin_id || $newPrice->quote != $oldPrice->quote)
            {
                $wrong++;
                continue;
            }
            if ($newPrice->price > 0 && $oldPrice->price > 0)
            {
                print($newPrice->price . '/' . $oldPrice->price . PHP_EOL);
                $change_24h = round(($newPrice->price / $oldPrice->price) / $newPrice->price * 100, 4);
            } else
            {
                $change_24h = 0;
            }
            print('$change_24h: ' . $change_24h. PHP_EOL);
            print(PHP_EOL);

            $i++;
        }
        print($i. PHP_EOL);
        print($wrong. PHP_EOL);
    }
}
