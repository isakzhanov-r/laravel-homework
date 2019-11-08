<?php


namespace App\Repositories\Order;


use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface OrderRepositoryContract
{
    public function getAll(): EloquentCollection;

    public function getGrouped($with_all = false): Collection;

    public function getOrder($id): Order;

    public function destroy(Order $order);
}
