<?php


namespace App\Repositories\Product;


use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAll(): EloquentCollection
    {
        return $this->model->query()
            ->with('vendor')
            ->get();
    }

    public function update(UpdateRequest $request, Product $product): Product
    {
        $fillable = $this->model->getFillable();
        $product->update($request->only($fillable));

        return $product;
    }
}
