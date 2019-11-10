<?php


namespace App\Repositories\Product;


use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface ProductRepositoryContract
{
    public function getAll(): EloquentCollection;

    public function update(UpdateRequest $request, Product $product): Product;
}
