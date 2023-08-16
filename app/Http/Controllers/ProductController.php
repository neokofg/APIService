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
        return response()->json(["message" => 'Успешно!', 'products' => $this->productService->index($request), 'status' => true], ResponseAlias::HTTP_OK);
    }
}
