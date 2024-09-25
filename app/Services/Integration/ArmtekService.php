<?php

namespace App\Services\Integration;

use App\Http\Resources\ProductResource;
use App\Models\Analogue;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArmtekService
{
    protected function send($method, $data): mixed
    {
        try {
            $response = Http::withBasicAuth(config('armtek.login'), config('armtek.pass'))
                ->post($method, $data);
            return json_decode($response->body(), true);
        } catch (\Exception $e) {
            Log::error($e);
            return new \Exception('Error connecting to Armtek', 500);
        }

    }

    public function search($pin)
    {
        $dbSearch = Product::query()
            ->where('articulate', 'LIKE', '%'.$pin.'%')
            ->get();

        if (!$dbSearch->isEmpty()) {
            $result = $dbSearch;
        } else {
            $armtekSearch = $this->send(
                'http://ws.armtek.kz/api/ws_search/search?format=json',
                [
                    'VKORG' => config('armtek.vkorg'),
                    'KUNNR_RG' => config('armtek.kunnr'),
                    'PIN' => $pin,
                    'QUERY_TYPE' => '2', // Возвращает аналоги
                ],
            );

            $findProducts = $this->saveProductsAndAnalogues($armtekSearch['RESP']);

            $result = Product::query()
                ->whereIn('id', $findProducts)
                ->get();
        }

        return ProductResource::collection($result);
    }

    public function saveProductsAndAnalogues($data)
    {
        try {
            $analogues = [];
            $baseProducts = [];

            foreach ($data as $product) {
                $savedProduct = Product::query()
                    ->updateOrCreate(
                        [
                            'articulate' => $product['PIN'],
                            'price' => $product['PRICE'],
                        ],
                        [
                            'name' => $product['BRAND'].' '.$product['NAME'],
                            'articulate' => $product['PIN'],
                            'description' => $product['BRAND'].' '.$product['NAME'],
                        ]
                    );

                if (Str::length($product['ANALOG']) == 0) {
                    $baseProducts[] = $savedProduct->id;
                } else {
                    $analogues[] = $savedProduct->id;
                }

            }

            foreach ($baseProducts as $baseProductId) {
                // Проходим по каждому аналогу
                foreach ($analogues as $analogueId) {
                    // Создаем запись в таблице Analogues
                    Analogue::query()
                        ->firstOrCreate([
                                'product_id' => $baseProductId,
                                'analogue_id' => $analogueId,
                            ]
                        );
                }
            }
        } catch (\Exception $e) {
            $baseProducts = [];
        }
        return $baseProducts;
    }
}
