<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {

    }
    public function index(ProductIndexRequest $request)
    {
        $products = $this->productService->index($request);
        if(count($products) > 0){
            return response()->json([
                "message" => 'Успешно!',
                'products' => $products,
                'status' => true
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                "message" => 'Не удалось найти продукты!',
                'status' => false
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
}
