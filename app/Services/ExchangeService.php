<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ExchangeService
{
    public function parseFile($content, $filename)
    {

        Log::info('filename: ' .$filename);
        //это пиздец.
        if ($filename == "import0_1.xml") {
            $xml = simplexml_load_string($content);
            if (!$xml) {
                throw new \Exception("Error loading XML data");
            }
            if (isset($xml->Каталог)) {
                foreach ($xml->Каталог->Товары->Товар as $product) {
                    if (!Product::where('id_1с', (string)$product->Ид)->first()){
                        Product::create([
                            'name' => (string)$product->Наименование,
                            'articul' => (string)$product->Артикул,
                            'barcode' => (string)$product->Штрихкод,
                            'description' => (string)$product->Описание,
                            'id_1с' => (string)$product->Ид
                        ]);
                    }
                }
            }
            Log::info('import is okay');

        } elseif ($filename == "offers0_1.xml") {
            $xml = simplexml_load_string($content);
            if (!$xml) {
                throw new \Exception("Error loading XML data");
            }
            if (isset($xml->ПакетПредложений)) {
                foreach ($xml->ПакетПредложений->Предложения->Предложение as $product) {
                    Product::where('id_1с', (string)$product->Ид)->update(['price'=>(double)$product->Цены->Цена->ЦенаЗаЕдиницу]);
                }
            }
            Log::info('offers is okay');
        }

    }
}
