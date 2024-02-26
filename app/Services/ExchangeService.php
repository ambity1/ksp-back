<?php

namespace App\Services;

use App\Jobs\OfferJob;
use App\Jobs\ParseJob;
use App\Jobs\ProductJob;
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
                Log::error('error syntax invalid xml file in products');
            }
            if (isset($xml->Каталог)) {
                foreach ($xml->Каталог->Товары->Товар as $product) {
                    $id = (string)$product->Ид;
                    $name = (string)$product->Наименование;
                    $articul = (string)$product->Артикул;
                    $barcode = (string)$product->Штрихкод;
                    $description = (string)$product->Описание;
                    ProductJob::dispatch($id, $name, $articul, $barcode, $description);
                }
            }

        } elseif ($filename == "offers0_1.xml") {
            $xml = simplexml_load_string($content);
            if (!$xml) {
                Log::error('error syntax invalid xml file in offers');
            }
            if (isset($xml->ПакетПредложений)) {
                foreach ($xml->ПакетПредложений->Предложения->Предложение as $product) {
                    $id = $product->Ид;
                    $price = $product->Цены->Цена->ЦенаЗаЕдиницу;
                    OfferJob::dispatch($id, $price);
                }
            }
        }

    }
}
