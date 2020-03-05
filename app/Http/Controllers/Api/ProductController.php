<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Product\ProductRepositoryContract;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $products;

    public function __construct(ProductRepository $product_repository)
    {
        $this->products = $product_repository;
    }

    public function index()
    {
        $data = $this->products
            ->getAll();

        return ProductResource::collection($data);
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $data = $this->products
            ->update($request, $product);

        return ProductResource::make($data, trans('statuses.updated'));
    }
}
