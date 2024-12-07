<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyConversionController extends Controller
{
    public function convert($amount, $from, $to)
    {
        $response = Http::get("https://api.exchangeratesapi.io/latest?base=$from");
        $rates = $response->json();

        if (!isset($rates['rates'][$to])) {
            return redirect()->back()->with('error', 'Currency conversion rate not found');
        }

        $conversionRate = $rates['rates'][$to];
        $convertedAmount = $amount * $conversionRate;

        return response()->json([
            'converted_amount' => round($convertedAmount, 2),
            'currency' => $to
        ]);
    }
}
