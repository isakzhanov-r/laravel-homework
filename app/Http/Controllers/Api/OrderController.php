<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\Orders\GroupedCollection;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Http\Resources\Json\Resource;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderRepository $order_repository_contract)
    {
        $this->order = $order_repository_contract;
    }

    public function index()
    {
        $data = $this->order
            ->getAll();

        return OrderResource::collection($data);
    }

    public function grouped()
    {
        $data = $this->order
            ->getAll();

        return GroupedCollection::make($data);
    }

    public function show(Order $order)
    {
        $data = $this->order
            ->getOrder($order);

        return Resource::make($data);
    }

    public function update(UpdateRequest $request, Order $order)
    {
        $data = $this->order
            ->update($request, $order);

        return OrderResource::make($data, trans('statuses.updated'));
    }

    public function destroy(Order $order)
    {
        if ($this->order->destroy($order)) {
            return response()->json(['message' => trans('statuses.deleted')]);
        }

        return response()->json(['message' => trans('statuses.fail')], 400);
    }
}
