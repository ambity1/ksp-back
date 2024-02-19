<?php

namespace App\Services;

use App\Jobs\ParseJob;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ExchangeService
{
    public function parseFile($content, $filename)
    {

        ParseJob::dispatch($content, $filename);

    }
}
