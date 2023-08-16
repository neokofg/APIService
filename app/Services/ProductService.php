<?php

namespace App\Services;

use App\Models\Product;

class ProductService {

    public function index($request)
    {
        $perPage = $request->first ?? 15;
        $pageName = 'products';
        $page = $request->page ?? 1;
        return Product::paginate($perPage, ['*'], $pageName, $page);
    }

}
