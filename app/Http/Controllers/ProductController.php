<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductBuyRequest;
use App\Http\Requests\ProductFindRequest;
use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductRentRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {

    }
    /**
     * @param ProductIndexRequest $request
     *  Получение всех продуктов
     * @return JsonResponse
     */
    public function index(ProductIndexRequest $request): JsonResponse
    {
        $products = $this->productService->index($request);
        if (count($products) > 0) {
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

    public function find(ProductFindRequest $request): JsonResponse
    {
        $product = $this->productService->find($request);
        if ($product) {
            return response()->json([
                "message" => 'Успешно!',
                'product' => $product,
                'status' => true,
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                "message" => 'Произошла непредвиденная ошибка!',
                'status' => false,
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @param ProductBuyRequest $request
     *  Покупка продукта
     * @return JsonResponse
     */
    public function buy(ProductBuyRequest $request): JsonResponse
    {
        $product = $this->productService->buy($request);
        if ($product) {
            return response()->json([
                "message" => 'Успешно!',
                'product' => $product,
                'status' => true,
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                "message" => 'Продукт уже был куплен!',
                'status' => false,
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @param ProductUpdateRequest $request
     *  Обновление продукта
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request): JsonResponse
    {
        $product = $this->productService->update($request->validated());
        if ($product) {
            return response()->json([
                "message" => 'Успешно!',
                'product' => $product,
                'status' => true,
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                "message" => 'Произошла непредвиденная ошибка!',
                'status' => false,
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @param ProductRentRequest $request
     *  Аренда продукта
     * @return JsonResponse
     */
    public function rent(ProductRentRequest $request): JsonResponse
    {
        $product = $this->productService->rent($request);
        if ($product) {
            return response()->json([
                "message" => 'Успешно!',
                'product' => $product,
                'status' => true,
            ], ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                "message" => 'Произошла непредвиденная ошибка!',
                'status' => false,
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }
}
