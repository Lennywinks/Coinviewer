<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CoinController extends Controller
{
    public function show(Request $request, string $id): Response
    {

        return Inertia::render('Coin/Coin', [
            'coinPrices' => Coin::with((['prices' => function ($query)
            {
                $query->where('quote', $this->selectedQuote);
            }]))
            ->select('id', 'name', 'symbol', 'rank',
                'total_supply', 'max_supply', 'beta_value')
            ->where('id', $id)
            ->first(),


//
//            'filters' => [
//                'quote' => $quote,
//                'search' => request()->input('search'),
//            ]
        ]);
    }
}
