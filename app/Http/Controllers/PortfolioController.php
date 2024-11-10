<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function show(Request $request): Response
    {
        return Inertia::render('Portfolio/View', [
            'coins' => Coin::query()
                ->orderBy('rank')
                ->select('id', 'name')
                ->get(),

            'transactions' => Transaction::query()
                ->with('coin')
                ->where('user_id', Auth::id())
                ->get()
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
       $request->validate([
           'coin_id' => [
               'required',
               Rule::unique('transactions', 'coin_id')
                   ->where('user_id', Auth::id()),
           ],
           'amount' => [
               'required',
               'numeric'
           ]
       ]);

       Transaction::create([
           'user_id' => Auth::id(),
           'coin_id' => $request->get('coin_id'),
           'amount' => $request->get('amount'),
       ]);

       return to_route('portfolio.show');
    }
}
