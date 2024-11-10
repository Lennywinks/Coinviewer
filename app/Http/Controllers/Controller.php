<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected String $selectedQuote;

    public function __construct(Request $request)
    {
        $this->selectedQuote = $request->query('quote', 'EUR');
        Inertia::share('selectedQuote', $this->selectedQuote);
    }
}
