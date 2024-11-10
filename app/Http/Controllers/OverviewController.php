<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OverviewController extends Controller
{
    public function show(Request $request): Response
    {
        return Inertia::render('Overview/Overview', [
            'coins' => Coin::with(['currentPrice' => function ($query)
                {
                    $query->where('quote', $this->selectedQuote);
                }])
                ->when(request()->input('search'), function ($query, $search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                })
                ->select('id', 'name', 'symbol', 'rank')
                ->orderBy('rank')
                ->paginate(10)
                ->withQueryString(),

            'filters' => [
                'search' => request()->input('search'),
            ]
        ]);
    }
}
