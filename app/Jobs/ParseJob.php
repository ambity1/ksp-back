<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ExchangeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ParseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $content;
    protected $filename;
    public function __construct($content, $filename)
    {
        $this->content = $content;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle($content, $filename): void
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
                    Product::where('id_1с', (string)$product->Ид)->update(['price'=>$product->Цены->Цена->ЦенаЗаЕдиницу]);
                }
            }
            Log::info('offers is okay');
        }
    }
}
