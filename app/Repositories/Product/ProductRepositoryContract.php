<?php


namespace App\Repositories\Product;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface ProductRepositoryContract
{
    public function getAll():EloquentCollection;
}
