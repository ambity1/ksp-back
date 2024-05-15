<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductSingleResource;
use App\Http\Resources\PromotionResource;
use App\Http\Resources\PromotionSingleResource;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function getPromotionByID(string $id)
    {
        return new PromotionSingleResource(Promotion::findOrFail($id));
    }

    public function getPromotions()
    {
        return PromotionResource::collection(Promotion::all());
    }
}
