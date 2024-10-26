<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\CoinPrice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OverviewController extends Controller
{
    public function show(Request $request): Response
    {
        $quote = $request->input('quote') ?? 'EUR';

        return Inertia::render('Overview/Overview', [
            'quote' => $quote,

            'coinPrices' => CoinPrice::query()
                ->select('date', 'price', 'quote')
                ->where('quote', $quote)
                ->where('coin_id', 'btc-bitcoin')
                ->get(),

            'coins' => Coin::with(['currentPrice' => function ($query) use ($quote)
                {
                    $query->where('quote', $quote);
                }])
                ->select('id', 'name', 'symbol', 'rank', 'total_supply')
                ->orderBy('rank')
                ->get()
        ]);
    }
}
