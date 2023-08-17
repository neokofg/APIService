<?php

namespace App\GraphQL\Mutations;

use App\Services\ProductService;
use GraphQL\Error\Error;

final class UpdateProduct
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __construct(private ProductService $productService)
    {
    }

    public function __invoke($_, array $args)
    {
        $product = $this->productService->update($args);
        if($product){
            return $product;
        } else {
            throw new Error("Не удалось обновить продукт!");
        }
    }
}
