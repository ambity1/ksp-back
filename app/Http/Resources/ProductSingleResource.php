<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'articulate' => $this['articulate'],
            'price' => $this['price'],
            'description' => $this['description'],
            'barcode' => $this['barcode'],
            'breadcrumbs' => $this['name'],
        ];
    }
}
