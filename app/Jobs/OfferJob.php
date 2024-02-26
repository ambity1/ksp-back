<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OfferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = Storage::disk('local')->get($this->filename);
        $xml = simplexml_load_string($file);
        if (!$xml) {
            Log::error('error syntax invalid xml file in offers');
        }

        if (isset($xml->ПакетПредложений)) {
            foreach ($xml->ПакетПредложений->Предложения->Предложение as $product) {
                Product::where('id_1с', $product->Ид)->update([
                    'price' => $product->Цены->Цена->ЦенаЗаЕдиницу
                ]);
            }
        }

    }
}
