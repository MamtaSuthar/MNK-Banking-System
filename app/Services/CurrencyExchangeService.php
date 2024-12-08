<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyExchangeService
{
    protected $apiUrl = 'https://api.exchangeratesapi.io/latest';
    protected $apiKey = 'YOUR_API_KEY'; // Replace with your actual API key

    public function getExchangeRate($fromCurrency, $toCurrency)
    {
        $response = Http::get("{$this->apiUrl}?base={$fromCurrency}&symbols={$toCurrency}&apikey={$this->apiKey}");
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['rates'][$toCurrency] ?? null;
        }

        return null;
    }
}
