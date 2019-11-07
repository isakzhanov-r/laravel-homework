<?php


namespace App\Repositories\Order;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface OrderRepositoryContract
{
    public function getAll():EloquentCollection;

    public function grouped($with_all = false): Collection;
}
