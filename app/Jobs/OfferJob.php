<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OfferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $id;
    private $price;
    public function __construct($id, $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Product::where('id_1с', $this->id)->update([
            'price' => $this->price
        ]);
    }
}
