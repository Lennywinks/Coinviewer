<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Utils\Statusbar;
use App\Models\Coin;
use App\Models\CoinPrice;

class ImportCoinPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-coin-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all coins and their current prices';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $apiUrl = 'https://api.coinpaprika.com/v1/tickers?quotes=USD,EUR,BTC';
        $coin_data = Http::get($apiUrl)->json();
        $i = 0;

        $len = count($coin_data);
        foreach ($coin_data as $data) {
            $coin = Coin::updateOrCreate(['id' => $data['id']], [
                'name' => $data['name'],
                'symbol' => $data['symbol'],
                'rank' => $data['rank'],
                'total_supply' => $data['total_supply'],
                'max_supply' => $data['max_supply'],
                'beta_value' => $data['beta_value'],
                'first_data_at' => Carbon::parse($data['first_data_at'])->format('Y-m-d H:i:s'),
                'last_updated' => Carbon::parse($data['last_updated'])->format('Y-m-d H:i:s'),
            ]);

            foreach (array_keys($data['quotes']) as $quote) {
               $price_information = $data['quotes'][$quote];

               $coin_price = CoinPrice::updateOrCreate(
                   [
                       'coin_id' => $data['id'],
                       'date' => date('Y-m-d'),
                       'quote' => $quote,
                   ],
                   [
                       'price' => $price_information['price'],
                       'volume_24h' => $price_information['volume_24h'],
                       'market_cap' => $price_information['market_cap'],
                       'ath_price' => $price_information['ath_price'],
                       'ath_date' => Carbon::parse($price_information['ath_date'])->format('Y-m-d H:i:s')
                   ]);
            }

            $i++;
            Statusbar::show_status($i , $len);
        }
    }
}
