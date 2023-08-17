<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductBuyRequest;
use App\Http\Requests\ProductFindRequest;
use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductRentRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

#[Group('Products')]
class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {

    }
    /**
     * Получение всех продуктов
     * @param ProductIndexRequest $request
     * @return JsonResponse
     */
    #[Response(['message' => 'Успешно!','products' => 'Array of Products', 'status' => true])]
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
    /**
     * Получение одного продукта
     * @param ProductFindRequest $request
     * @return JsonResponse
     */
    #[Response(['message' => 'Успешно!','product' => 'Product', 'status' => true])]
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
     * Покупка продукта
     * @param ProductBuyRequest $request
     * @header Authorization Bearer
     * @return JsonResponse
     */
    #[Response(['message' => 'Успешно!','product' => 'Product', 'status' => true])]
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
     * Обновление продукта
     * @param ProductUpdateRequest $request
     * @header Authorization Bearer
     * @return JsonResponse
     */
    #[Response(['message' => 'Успешно!','product' => 'Product', 'status' => true])]
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
     * Аренда продукта
     * @param ProductRentRequest $request
     * @header Authorization Bearer
     * @return JsonResponse
     */
    #[Response(['message' => 'Успешно!','product' => 'Product', 'status' => true])]
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
