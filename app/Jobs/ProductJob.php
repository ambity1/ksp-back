<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $id;
    private $name;
    private $articul;
    private $barcode;
    private $description;
    public function __construct($id, $name, $articul,$barcode,$description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->articul = $articul;
        $this->barcode = $barcode;
        $this->description = $description;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Product::updateOrCreate(
            [
                'id_1с' => $this->id
            ],
            [
                'name' => $this->name,
                'articul' => $this->articul,
                'barcode' => $this->barcode,
                'description' => $this->description
            ]
        );
    }
}
