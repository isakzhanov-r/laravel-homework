<?php


namespace App\Repositories\Eloquent;


use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::query()->get()
            ->load('vendor');
    }

    public function update(UpdateRequest $request, Product $product): Product
    {
        $product->update($request->validated());

        return $product;
    }
}
