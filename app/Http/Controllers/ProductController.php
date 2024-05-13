<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function getProductByID(string $id)
    {
       return new ProductResource(Product::findOrFail($id));
    }

    public function getProducts(string $typeSort, string | null $sort, string $limit)
    {
        $products = Product::whereNotNull('price');
        if ($typeSort === 'reverse'){
            $products = $products
                ->orderByDesc($sort);
        } elseif ($typeSort === 'normal') {
            $products = $products
                ->orderBy($sort);
        }
        $products = $products->paginate($limit);
        return ProductResource::collection($products);
    }

    public function getProductsFilterPrice(string $typeSort, string | null $sort, string $limit, string $from, string $to){
        $products = Product::whereNotNull('price')
            ->whereBetween('price', [$from, $to]);
        if ($typeSort === 'reverse'){
            $products = $products
                ->orderByDesc($sort);
        } elseif ($typeSort === 'normal') {
            $products = $products
                ->orderBy($sort);
        }
        $products = $products->paginate($limit);
        return ProductResource::collection($products);
    }

    public function getProductsWithoutPrice()
    {
        $products = Product::whereNull('price')->get();

        return ProductResource::collection($products);
    }
}
