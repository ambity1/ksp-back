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

class ProductJob implements ShouldQueue
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
            Log::error('error syntax invalid xml file in products');
        }
        if (isset($xml->Каталог)) {
            foreach ($xml->Каталог->Товары->Товар as $product) {
                Product::updateOrCreate(
                    [
                        'id_1с' => $product->Ид
                    ],
                    [
                        'name' => $product->Наименование,
                        'articulate' => $product->Артикул,
                        'barcode' => $product->Штрихкод,
                        'description' => $product->Описание,
                    ]
                );
            }
        }
        Storage::disk('local')->delete($this->filename);
    }
}
