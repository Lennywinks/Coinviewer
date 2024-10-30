<?php

namespace App\Console\Commands;

use App\Models\Coin;
use App\Utils\Statusbar;
use Illuminate\Console\Command;

class DownloadCoinLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-coin-logos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to download all logos from coinpaprika.com';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $coins = Coin::query()->orderBy("rank")->select('id')->get();

        $len = count($coins);
        $i = 0;
        foreach ($coins as $coin) {
            if (file_exists("./storage/app/logos/$coin->id.png")) {
                $i++;
                continue;
            }
            try {
                $img = file_get_contents("https://static.coinpaprika.com/coin/$coin->id/logo.png");
            } catch (\Exception $e) {
                print("Could not get image for $coin->id\n");
                $i++;
                continue;
            }
            file_put_contents("./storage/app/logos/$coin->id.png", $img);
            sleep(1);

            $i++;
            Statusbar::show_status($i , $len);
        }
    }
}
