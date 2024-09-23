<?php

namespace App\Services\Integration;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArmtekService
{
    protected function send($method, $data): \Exception|string
    {
        try {
            $response = Http::withBasicAuth(config('armtek.login'), config('armtek.pass'))
                ->post($method, $data);
            return $response->body();
        } catch (\Exception $e) {
            Log::error($e);
            return new \Exception('Error connecting to Armtek', 500);
        }

    }

    public function search($pin)
    {
        $searchResult = $this->send(
            'http://ws.armtek.kz/api/ws_search/search?format=json',
            [
                'VKORG' => config('armtek.vkorg'),
                'KUNNR_RG' => config('armtek.kunnr'),
                'PIN' => $pin,
                'QUERY_TYPE' => '1', // Возвращает аналоги
            ],
        );




    }
}
