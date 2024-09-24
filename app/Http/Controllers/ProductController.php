<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSingleResource;
use App\Models\Product;
use App\Services\Integration\ArmtekService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ArmtekService $armtekService;

    public function __construct(ArmtekService $armtekService)
    {
        $this->armtekService = $armtekService;
    }

    public function search($pin): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->armtekService->search($pin));
    }

    public function getProductByID(string $id)
    {
       return new ProductSingleResource(Product::findOrFail($id));
    }

    public function getProducts(Request $request)
    {
        $products = Product::whereNotNull('price');

        if ($request['name']) {
            $products = $products->where('name', 'like', '%' . $request['name'] . '%');
        }
        if ($request['typeSort'] === 'reverse'){
            $products = $products
                ->orderByDesc($request['sort']);
        } elseif ($request['typeSort'] === 'normal') {
            $products = $products
                ->orderBy($request['sort']);
        }
        $products = $products->paginate($request['limit']);
        return ProductResource::collection($products);
    }

    public function getProductsFilterPrice(Request $request){

        $products = Product::whereNotNull('price');
        if ($request['from'] && $request['to']){
            $products = $products->whereBetween('price', [$request['from'], $request['to']]);
        }
        if ($request['name']) {
            $products = $products->where('name', 'like', '%' . $request['name'] . '%');
        }
        if ($request['typeSort'] === 'reverse'){
            $products = $products
                ->orderByDesc($request['sort']);
        } elseif ($request['typeSort'] === 'normal') {
            $products = $products
                ->orderBy($request['sort']);
        }
        $products = $products->paginate($request['limit']);
        return ProductResource::collection($products);
    }

    public function getProductsWithoutPrice()
    {
        $products = Product::whereNull('price')->get();

        return ProductResource::collection($products);
    }

    public function getProductsRandom()
    {
        $products = Product::inRandomOrder()->limit(4)->get();

        return ProductResource::collection($products);
    }

    public function getMinMaxPrice(){
        return response()->json(['min'=>Product::min('price'), 'max'=>Product::max('price')]);
    }
}
