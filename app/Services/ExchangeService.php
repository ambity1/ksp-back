<?php

namespace App\Services;

use App\Jobs\OfferJob;
use App\Jobs\ParseJob;
use App\Jobs\ProductJob;
use App\Models\Product;

use Illuminate\Support\Facades\Storage;

class ExchangeService
{
    public function parseFile($content, $filename)
    {

        Storage::disk('local')->put($filename, $content);
        if ($filename == "import0_1.xml"){
            ProductJob::dispatch($filename);
        } elseif ($filename == "offers0_1.xml"){
            OfferJob::dispatch($filename);
        }
    }
}
